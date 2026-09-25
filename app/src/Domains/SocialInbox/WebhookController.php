<?php

namespace App\Domains\SocialInbox;

class WebhookController
{
    private \mysqli $mysqli;

    public function __construct(\mysqli $mysqli)
    {
        $this->mysqli = $mysqli;
    }

    public function instagram(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->verify();
            return;
        }

        $payload = json_decode(file_get_contents('php://input'), true);

        if (!$payload) {
            http_response_code(400);
            echo 'Invalid payload';
            return;
        }

        error_log('IG WEBHOOK: ' . json_encode($payload));

        $this->processEntries($payload, 'instagram');

        http_response_code(200);
        echo 'EVENT_RECEIVED';
    }

    public function messenger(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $this->verify();
            return;
        }

        $payload = json_decode(file_get_contents('php://input'), true);

        if (!$payload) {
            http_response_code(400);
            echo 'Invalid payload';
            return;
        }

        error_log('MESSENGER WEBHOOK: ' . json_encode($payload));

        $this->processEntries($payload, 'messenger');

        http_response_code(200);
        echo 'EVENT_RECEIVED';
    }

    private function verify(): void
    {
        $verifyToken = $_ENV['WEBHOOK_VERIFY_TOKEN'] ?? '';

        $mode      = $_GET['hub_mode'] ?? $_GET['hub.mode'] ?? '';
        $token     = $_GET['hub_verify_token'] ?? $_GET['hub.verify_token'] ?? '';
        $challenge = $_GET['hub_challenge'] ?? $_GET['hub.challenge'] ?? '';

        if ($mode === 'subscribe' && $token === $verifyToken) {
            http_response_code(200);
            echo $challenge;
            return;
        }

        http_response_code(403);
        echo 'Verification failed';
    }

    private function processEntries(array $payload, string $channel): void
    {
        foreach ($payload['entry'] ?? [] as $entry) {
            foreach ($entry['messaging'] ?? [] as $event) {
                $senderId = $event['sender']['id'] ?? null;
                $text     = $event['message']['text'] ?? null;

                if (!$senderId || !$text) {
                    continue;
                }

                error_log("[$channel] Mensaje de $senderId: $text");
            }
        }
    }
}
