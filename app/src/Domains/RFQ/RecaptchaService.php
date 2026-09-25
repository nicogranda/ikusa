<?php
declare(strict_types=1);

namespace App\Domains\RFQ\Services;

use GuzzleHttp\Client;

class RecaptchaService
{
    private string $secret;
    private Client $client;

    public function __construct()
    {
        $this->secret = $_ENV['GOOGLE_RECAPTCHA_SECRET_KEY'] ?? '';
        if (empty($this->secret)) {
            throw new \RuntimeException('Google reCAPTCHA secret key no configurada');
        }

        $this->client = new Client([
            'timeout' => 5
        ]);
    }

    /**
     * Valida la respuesta de reCAPTCHA
     */
    public function validate(string $captchaResponse, ?string $remoteIp = null): bool
    {
        if (empty($captchaResponse)) return false;

        $response = $this->client->post('https://www.google.com/recaptcha/api/siteverify', [
            'form_params' => [
                'secret'   => $this->secret,
                'response' => $captchaResponse,
                'remoteip' => $remoteIp,
            ]
        ]);

        $result = json_decode($response->getBody()->getContents(), true);

        return !empty($result['success']);
    }
}