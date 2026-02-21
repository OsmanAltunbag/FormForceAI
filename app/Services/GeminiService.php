<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class GeminiService
{
    private string $apiKey;
    private string $apiEndpoint = 'https://api.groq.com/openai/v1/chat/completions';
    private string $model = 'llama-3.3-70b-versatile';

    public function __construct()
    {
        $this->apiKey = config('services.groq.api_key');
        
        if (!$this->apiKey) {
            throw new Exception('GROQ_API_KEY is not set in .env file');
        }
    }

    public function generateForm(string $userPrompt, array $conversationHistory = []): array
    {
        $systemPrompt = <<<EOT
You are a form schema generator. Your job is to convert natural language descriptions into structured JSON form schemas.

You MUST return ONLY valid JSON with this exact structure:
{
  "title": "string",
  "description": "string",
  "fields": [
    {
      "label": "string",
      "type": "text|email|textarea|select|checkbox|radio|number|date",
      "name": "string",
      "required": true/false,
      "placeholder": "string",
      "options": ["array", "only", "for", "select", "radio"]
    }
  ]
}

Do not return any text before or after the JSON. Do not include markdown code blocks. Only return the raw JSON object.
EOT;

        $messages = [];

        // Add system prompt
        $messages[] = [
            'role' => 'system',
            'content' => $systemPrompt
        ];

        // Add conversation history
        if (!empty($conversationHistory)) {
            $messages = array_merge($messages, $conversationHistory);
        }

        // Add the new user message
        $messages[] = [
            'role' => 'user',
            'content' => $userPrompt
        ];

        $payload = [
            'model' => $this->model,
            'messages' => $messages,
            'temperature' => 0.7,
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->withoutVerifying()->post($this->apiEndpoint, $payload);

        if (!$response->successful()) {
            $error = $response->json('error.message') ?? $response->body();
            throw new Exception('Groq API request failed: ' . $error);
        }

        $responseData = $response->json();

        if (empty($responseData['choices'][0]['message']['content'])) {
            throw new Exception('Invalid response from Groq API: missing content');
        }

        $jsonText = $responseData['choices'][0]['message']['content'];
        $jsonText = trim($jsonText);

        // Remove markdown code blocks if present
        if (str_starts_with($jsonText, '```json')) {
            $jsonText = substr($jsonText, 7);
        }
        if (str_starts_with($jsonText, '```')) {
            $jsonText = substr($jsonText, 3);
        }
        if (str_ends_with($jsonText, '```')) {
            $jsonText = substr($jsonText, 0, -3);
        }

        $jsonText = trim($jsonText);

        $formSchema = json_decode($jsonText, true);

        if (!is_array($formSchema)) {
            throw new Exception('Groq API did not return valid JSON: ' . $jsonText);
        }

        return $formSchema;
    }
}
