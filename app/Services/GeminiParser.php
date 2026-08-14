<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiParser
{
    private string $apiKey;
    private string $model = 'gemini-2.0-flash';

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', '');
    }

    public function parseCV(string $text): array
    {
        $prompt = $this->buildPrompt($text);

        $response = Http::timeout(60)->post(
            "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}",
            [
                'contents' => [[
                    'parts' => [['text' => $prompt]],
                ]],
                'generationConfig' => [
                    'responseMimeType' => 'application/json',
                ],
            ]
        );

        if ($response->failed()) {
            throw new \RuntimeException('Gemini API error: ' . $response->body());
        }

        $raw = $response->json('candidates.0.content.parts.0.text', '{}');
        return json_decode($raw, true) ?? [];
    }

    private function buildPrompt(string $cvText): string
    {
        return <<<PROMPT
Ești un expert în parsarea CV-urilor. Extrage informațiile din CV-ul de mai jos și returnează un JSON valid cu această structură exactă:

{
  "personal": {
    "display_name": "",
    "headline": "",
    "phone": "",
    "email_contact": "",
    "location": "",
    "website": "",
    "linkedin": "",
    "github_url": ""
  },
  "summary": "",
  "goals": "",
  "target_role": "",
  "experiences": [
    {
      "title": "",
      "company": "",
      "location": "",
      "start_date": "YYYY-MM-DD",
      "end_date": "YYYY-MM-DD",
      "is_current": false,
      "description": ""
    }
  ],
  "educations": [
    {
      "institution": "",
      "degree": "",
      "field_of_study": "",
      "start_date": "YYYY-MM-DD",
      "end_date": "YYYY-MM-DD",
      "is_current": false
    }
  ],
  "skills": [
    { "name": "", "category": "", "level": "intermediate" }
  ],
  "languages": [
    { "name": "", "proficiency": "B2" }
  ],
  "certifications": [
    { "name": "", "issuer": "", "issued_at": "YYYY-MM-DD", "credential_url": "" }
  ]
}

Reguli:
- Dacă o informație nu există, lasă câmpul gol sau array-ul gol
- Pentru date, folosește formatul YYYY-MM-DD (ex: 2020-01-01). Dacă ai doar anul, folosește YYYY-01-01
- Pentru skills, nivel poate fi: beginner, intermediate, advanced, expert
- Pentru limbi, proficiency poate fi: A1, A2, B1, B2, C1, C2, Native
- Returnează DOAR JSON-ul, fără explicații

CV:
{$cvText}
PROMPT;
    }
}
