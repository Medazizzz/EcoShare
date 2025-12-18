<?php

namespace App\Service;

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class AiDescriptionService
{
    private HttpClientInterface $client;
    private CacheItemPoolInterface $cache;
    private string $apiKey;
    private string $hfModel;

    public function __construct(
        HttpClientInterface $client,
        CacheItemPoolInterface $cache,
        string $huggingfaceApiKey,
        string $huggingfaceModel
    ) {
        $this->client  = $client;
        $this->cache   = $cache;
        $this->apiKey  = $huggingfaceApiKey;
        $this->hfModel = $huggingfaceModel;
    }

    public function generate(string $context): string
    {
        if (trim($this->apiKey) === '') {
            return $this->fallback();
        }

        $angles = [
            'informatif',
            'inspirant',
            'appel à l’action',
            'orienté bénéfices',
            'court et accrocheur',
            'professionnel neutre',
        ];
        $angle = $angles[random_int(0, count($angles) - 1)];
        $nonce = random_int(100000, 999999);

        $prompt = <<<PROMPT
Tu es un rédacteur marketing éco-responsable.
Rédige une description UNIQUE en français, angle {$angle}.
Contraintes :
- 1 à 2 phrases
- 18 à 40 mots
- ton professionnel
- pas d’emoji, pas de hashtags, pas de guillemets

Contexte : {$context}
Clé de variation : {$nonce}

Réponds uniquement avec la description.
PROMPT;

        try {
            $response = $this->client->request(
                'POST',
                'https://api-inference.huggingface.co/models/' . $this->hfModel,
                [
                    'headers' => [
                        'Authorization' => 'Bearer ' . $this->apiKey,
                        'Content-Type'  => 'application/json',
                    ],
                    'json' => [
                        'inputs' => $prompt,
                        'parameters' => [
                            'max_new_tokens' => 100,
                            'do_sample' => true,
                            'temperature' => 0.95,
                            'top_p' => 0.9,
                            'repetition_penalty' => 1.15,
                            'return_full_text' => false,
                        ],
                        'options' => [
                            'use_cache' => false,
                            'wait_for_model' => true,
                        ],
                    ],
                    'timeout' => 30,
                ]
            );

            $raw = $response->getContent(false);
            $data = json_decode($raw, true);

            if (isset($data[0]['generated_text'])) {
                return trim($data[0]['generated_text']);
            }

            if (isset($data['generated_text'])) {
                return trim($data['generated_text']);
            }

        } catch (\Throwable $e) {
            // silent fallback
        }

        return $this->fallback();
    }

    private function fallback(): string
    {
        $fallbacks = [
            'Découvrez une initiative engagée qui valorise des solutions durables et responsables.',
            'Une démarche éco-responsable pensée pour réduire l’impact environnemental au quotidien.',
            'Une action engagée mettant en avant des pratiques durables et utiles.',
        ];

        return $fallbacks[random_int(0, count($fallbacks) - 1)];
    }
}
