<?php
namespace App\Services;


use Illuminate\Support\Facades\Http;

class OpenAiService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.openai.com/v1';

    public function __construct()
    {
        $this->apiKey = env('OPENAI_API_KEY');
    }

    public function generateText($prompt)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type' => 'application/json',
        ])->post("{$this->baseUrl}/engines/davinci/completions", [
            'prompt' => $prompt,
            'max_tokens' => 100,
            'temperature' => 0.7,
        ]);

        if ($response->successful()) {
            return $response->json()['choices'][0]['text'];
        }

        return 'No se pudo generar el texto.';
    }
}
