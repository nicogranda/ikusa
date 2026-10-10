<?php
require dirname(__DIR__) . '/vendor/autoload.php';
require dirname(__DIR__) . '/app/src/Domains/Appointments/Calendar/bootstrap.php';
use App\Domains\Appointments\Calendar\Domain\Event;
use App\Domains\Appointments\Calendar\Infrastructure\FileTokenStore;
use App\Domains\Appointments\Calendar\Infrastructure\GoogleConnection;
use App\Domains\Appointments\Calendar\Infrastructure\GoogleEventRepository;
use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Response;
function check(bool $condition, string $message): void { if (!$condition) throw new RuntimeException($message); }
function rejects(Closure $callback): void { try { $callback(); } catch (InvalidArgumentException $e) { return; } throw new RuntimeException('Expected validation failure'); }
$input = ['summary' => 'Test', 'start' => '2026-10-10T10:00', 'end' => '2026-10-10T11:00'];
$payload = Event::payload($input);
check(str_ends_with($payload['start']['dateTime'], '+02:00'), 'Madrid summer offset');
$winter = Event::payload(array_replace($input, ['start'=>'2026-12-10T10:00','end'=>'2026-12-10T11:00']));
check(str_ends_with($winter['start']['dateTime'], '+01:00'), 'Madrid winter offset');
rejects(fn()=>Event::payload(array_replace($input,['start'=>'2026-02-30T10:00'])));
rejects(fn()=>Event::payload(array_replace($input,['end'=>$input['start']])));
rejects(fn()=>Event::payload(array_replace($input,['summary'=>' '])));
$requests = [];
$mock = new MockHandler([
 new Response(200, [], '{"items":[{"id":"one","summary":"One"}],"nextPageToken":"next"}'),
 new Response(200, [], '{"items":[{"id":"two","summary":"Two"}]}'),
 new Response(200, [], '{"id":"created","summary":"Test"}'),
 new Response(200, [], '{"id":"created","summary":"Updated"}'),
 new Response(200, [], '{"id":"created","summary":"Updated"}'),
 new Response(204),
]);
$stack = HandlerStack::create($mock); $stack->push(Middleware::history($requests));
$client = new Google\Client(); $client->setAccessToken(['access_token'=>'fake','created'=>time(),'expires_in'=>3600]); $client->setHttpClient(new HttpClient(['handler'=>$stack]));
$repo = new GoogleEventRepository(new Google\Service\Calendar($client));
check(count($repo->list('2026-10-01T00:00:00+02:00','2026-11-01T00:00:00+01:00'))===2,'Pagination');
check($repo->create($payload)['id']==='created','Create');
check($repo->update('created',array_replace($payload,['summary'=>'Updated']))['summary']==='Updated','Patch');
check($repo->get('created')['id']==='created','Get');
$repo->delete('created');
check(array_map(fn($r)=>$r['request']->getMethod(), $requests)===['GET','GET','POST','PATCH','GET','DELETE'],'CRUD methods');
check(str_contains((string)$requests[1]['request']->getUri(),'pageToken=next'),'Pagination cursor');
rejects(fn()=> $repo->delete('../bad'));
$directory = sys_get_temp_dir().'/ikusa-calendar-'.bin2hex(random_bytes(6));
$store = new FileTokenStore($directory.'/token.json');
try {
 $store->write(['access_token'=>'expired','refresh_token'=>'keep-me','created'=>1,'expires_in'=>1]);
 check((fileperms($directory.'/token.json') & 0777)===0600,'Private token file');
 $refreshMock = new MockHandler([new Response(200,['Content-Type'=>'application/json'],'{"access_token":"renewed","expires_in":3600,"token_type":"Bearer"}')]);
 $factory = function() use ($refreshMock) { $c = new Google\Client(['client_id'=>'fake-id','client_secret'=>'fake-secret']); $c->setHttpClient(new HttpClient(['handler'=>HandlerStack::create($refreshMock), 'http_errors'=>false])); return $c; };
 $connection = new GoogleConnection($store,$factory);
 check($connection->authorizedClient()->getAccessToken()['access_token']==='renewed','Refresh expired token');
 check($store->read()['refresh_token']==='keep-me','Preserve refresh token');
 check($connection->authorizedClient()->getAccessToken()['access_token']==='renewed','Reuse refreshed token without new request');
 $store->write(['access_token'=>'expired','refresh_token'=>'revoked','created'=>1,'expires_in'=>1]);
 $refreshMock->append(new Response(400,['Content-Type'=>'application/json'],'{"error":"invalid_grant"}'));
 try { $connection->authorizedClient(); throw new LogicException('Expected invalid_grant'); } catch (RuntimeException $e) { check(!$connection->connected(),'Revoked connection cleared'); }
 $_SESSION=['user_id'=>1,'user'=>['role'=>'admin']]; $_SERVER['HTTP_HOST']='localhost:8888';
 $_ENV['GOOGLE_CLIENT_ID']='fake-id'; $_ENV['GOOGLE_CLIENT_SECRET']='fake-secret';
 $real = new GoogleConnection($store);
 parse_str(parse_url($real->authorizationUrl(),PHP_URL_QUERY),$query);
 check($query['redirect_uri']==='http://localhost:8888/ikusa/admin','Local existing callback');
 check($query['access_type']==='offline' && $query['prompt']==='consent','Offline consent');
 check(str_contains($query['scope'],GoogleConnection::SCOPE),'Calendar scope');
 try { $real->callback(['state'=>'forged','code'=>'fake']); throw new LogicException('Expected state rejection'); } catch (RuntimeException $e) { check(!$real->connected(),'Forged callback does not write tokens'); }
 check(!isset($_SESSION['calendar_oauth']),'Single use OAuth state');
 $oauthClient = new class extends Google\Client {
     public array $claims = ['email'=>'ikusa.creativestudio@gmail.com','email_verified'=>true];
     public function fetchAccessTokenWithAuthCode($code, $codeVerifier = null) { return ['access_token'=>'valid','refresh_token'=>'offline','expires_in'=>3600,'id_token'=>'fake','scope'=>GoogleConnection::SCOPE]; }
     public function verifyIdToken($idToken = null) { return $this->claims; }
 };
 $oauth = new GoogleConnection($store, fn()=>$oauthClient);
 $_SESSION['calendar_oauth']=['state'=>'valid-state','expires'=>time()+600,'user_id'=>1];
 $oauth->callback(['state'=>'valid-state','code'=>'code']);
 check($oauth->connected() && $store->read()['account_email']==='ikusa.creativestudio@gmail.com','Valid callback persisted');
 $oauthClient->claims['email']='another@gmail.com';
 $_SESSION['calendar_oauth']=['state'=>'valid-state','expires'=>time()+600,'user_id'=>1];
 try { $oauth->callback(['state'=>'valid-state','code'=>'code']); throw new LogicException('Expected wrong account rejection'); } catch (RuntimeException $e) { check($store->read()['account_email']==='ikusa.creativestudio@gmail.com','Wrong account cannot overwrite connection'); }

 $_SERVER['HTTP_HOST']='ikusa.net'; check(GoogleConnection::redirectUri()==='https://ikusa.net/admin','Production callback');
 echo "OK: validation, Madrid DST, paginated CRUD, token persistence/refresh/revocation, OAuth state and callback URLs\n";
} finally { foreach (glob($directory.'/*') ?: [] as $file) unlink($file); if (is_dir($directory)) rmdir($directory); }
