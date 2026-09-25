<?php
class OpenAIService {
    private $apiKey;

    public function __construct() {
        $this->apiKey = $_ENV['API_KEY_OPEN_AI'] ?? '';
    }

    public function sendMessage($messages){

        $data = [
            "model" => "gpt-4.1-mini",
            "messages" => $messages,
            "temperature" => 0.7
        ];

        $ch = curl_init("https://api.openai.com/v1/chat/completions");

        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_HTTPHEADER => [
                "Content-Type: application/json",
                "Authorization: Bearer ".$this->apiKey
            ],
            CURLOPT_POSTFIELDS => json_encode($data)
        ]);

        $response = curl_exec($ch);

        if(curl_errno($ch)){
            return "Curl error: " . curl_error($ch);
        }

        curl_close($ch);

        $result = json_decode($response,true);

        if(isset($result['error'])){
            return "API Error: ".$result['error']['message'];
        }

        return $result['choices'][0]['message']['content'] ?? "Sin respuesta";
    }
}
