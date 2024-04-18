<?php
namespace App\Services;


use Illuminate\Support\Facades\Http;

class OpenAiService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.openai.com/v1/chat/completions';

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function generateText($prompt)
    {
        $response = Http::retry(3, 100)
            ->connectTimeout(60)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type' => 'application/json',
            ])
            ->post("{$this->baseUrl}", [
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $prompt
                ]
            ]
        ]);
        if ($response->successful()) {

            return $response->json()['choices'][0]['message']["content"];

        }

        return 'No se pudo generar el texto.';
    }
}
