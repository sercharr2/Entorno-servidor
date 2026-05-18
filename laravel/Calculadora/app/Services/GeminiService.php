<?php

namespace App\Services;

use RuntimeException;

class GeminiService
{
    private string $apiKey;
    private string $url;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.key', '');
        $this->url    = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $this->apiKey;
    }

    public function generateWord(string $tema = 'cultura general'): array
    {
        $prompt = 'Actua como un backend para un juego del ahorcado en español. '
                . 'Genera una palabra al azar en español (sin espacios, sin tildes, solo letras A-Z) y una pista corta. '
                . "El tema es: {$tema}. "
                . 'Responde UNICAMENTE con JSON puro, sin texto adicional, sin bloques de codigo: '
                . '{"palabra": "...", "pista": "..."}';

        $payload = json_encode([
            'contents' => [['parts' => [['text' => $prompt]]]],
        ]);

        $ch = curl_init($this->url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT        => 15,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $raw = curl_exec($ch);
        curl_close($ch);

        if ($raw === false) {
            throw new RuntimeException('No se pudo conectar con la IA de Gemini.');
        }

        $data = json_decode($raw, true);
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;

        if (!$text) {
            $msg = $data['error']['message'] ?? 'Error desconocido de la API.';
            throw new RuntimeException($msg);
        }

        $clean  = preg_replace('/^```(?:json)?\s*|\s*```$/m', '', trim($text));
        $result = json_decode($clean, true);

        if (!is_array($result) || !isset($result['palabra'], $result['pista'])) {
            throw new RuntimeException('La IA devolvió una respuesta inesperada.');
        }

        return [
            'palabra' => strtoupper(preg_replace('/[^A-Za-z]/', '', $result['palabra'])),
            'pista'   => $result['pista'],
        ];
    }
}
