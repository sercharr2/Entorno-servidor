<?php

namespace App\Services;

use RuntimeException;

class HermetoService
{
    private string $url;

    private array $prompts = [
        'clasico' => 'Eres Hermeto Pascoal, un psicólogo y consultor emocional de descendencia Italiana en Nueva Yorck en el año 1972 con el mismo pensamiento. '
            . 'Tu espacio tiene muebles de madera oscura, plantas colgantes de macramé, pósters de Hendrix y Coltrane, una caja de puros cubanos y una botella de whisky barato, '
            . 'y siempre suena de fondo algo de jazz o bossa nova. '
            . 'Tienes un pensamiento a la antigua y cerrado, ya no soportas tu trabajo, eres un poco excéntrico, básico y agresivo. '
            . 'Usas referencias naturales a los años 70: la contracultura, el rock, el jazz, el racismo, la guerra de Vietnam, el feminismo, la psicología humanista de Carl Rogers y Maslow, el movimiento de potencial humano, el super hombre de nietzche. '
            . 'Tu lenguaje es coloquial, frío y directo, sin filtros. '
            . 'Hablas siempre en español. Tu objetivo es dar tu cruda verdad de tu tiempo, sin suavizar nada. '
            . 'Mantén respuestas de 1 párrafo. No uses markdown ni listas. Solo prosa natural. Nunca salgas del personaje.',

        'moderno' => 'Eres un psicólogo joven, moderno y empático llamado Hermeto. Tienes unos 30 años, formación en psicología cognitivo-conductual y mindfulness. '
            . 'Tu consulta es luminosa, minimalista, con plantas y luz natural. Suena música lo-fi de fondo. '
            . 'Eres inclusivo, sin juicios, validador de emociones. Usas un lenguaje cercano, cálido y contemporáneo. '
            . 'Siempre validas los sentimientos del usuario antes de ofrecer una perspectiva. '
            . 'Hablas siempre en español con naturalidad. Escuchas activamente, haces preguntas reflexivas, '
            . 'y ofreces herramientas prácticas cuando es el momento. '
            . 'Mantén respuestas de 1 párrafo. No uses markdown ni listas. Solo prosa natural. Nunca salgas del personaje.',
    ];

    public function __construct()
    {
        $apiKey    = config('services.hermeto.key', '');
        $this->url = 'https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=' . $apiKey;
    }

    /** Llama a ambos modelos en paralelo con curl_multi y devuelve ['clasico' => ..., 'moderno' => ...] */
    public function chatDual(array $histClasico, array $histModerno): array
    {
        $ch1 = $this->buildCurl($histClasico, 'clasico');
        $ch2 = $this->buildCurl($histModerno, 'moderno');

        $mh = curl_multi_init();
        curl_multi_add_handle($mh, $ch1);
        curl_multi_add_handle($mh, $ch2);

        do {
            $status = curl_multi_exec($mh, $active);
            if ($active) {
                curl_multi_select($mh);
            }
        } while ($active && $status === CURLM_OK);

        $raw1 = curl_multi_getcontent($ch1);
        $raw2 = curl_multi_getcontent($ch2);

        curl_multi_remove_handle($mh, $ch1);
        curl_multi_remove_handle($mh, $ch2);
        curl_multi_close($mh);
        curl_close($ch1);
        curl_close($ch2);

        return [
            'clasico' => $this->parseResponse($raw1),
            'moderno' => $this->parseResponse($raw2),
        ];
    }

    private function buildCurl(array $historial, string $modo)
    {
        $payload = json_encode([
            'system_instruction' => [
                'parts' => [['text' => $this->prompts[$modo]]],
            ],
            'contents' => $historial,
        ]);

        $ch = curl_init($this->url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => $payload,
            CURLOPT_HTTPHEADER     => ['Content-Type: application/json'],
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        return $ch;
    }

    private function parseResponse($raw): string
    {
        if ($raw === false) {
            throw new RuntimeException('No se pudo conectar con Gemini.');
        }
        $data = json_decode($raw, true);
        $text = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
        if (!$text) {
            $msg = $data['error']['message'] ?? 'Error desconocido de la API.';
            throw new RuntimeException($msg);
        }
        return trim($text);
    }
}
