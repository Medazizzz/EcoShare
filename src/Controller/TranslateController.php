<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslateController extends AbstractController
{
    #[Route('/api/translate', name: 'api_translate', methods: ['POST'])]
    public function translate(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true) ?? [];

        $text   = $data['text']   ?? '';
        $target = $data['target'] ?? 'en';

        if (!\is_string($text) || trim($text) === '') {
            return new JsonResponse(['error' => 'No text provided'], 400);
        }

        try {
            $translator = new GoogleTranslate();
            // auto-detect source
            $translator->setSource(null);
            $translator->setTarget($target);

            $translated = $translator->translate($text);

            return new JsonResponse([
                'translated' => $translated,
                'target'     => $target,
                'provider'   => 'google-translate',
            ]);
        } catch (\Throwable $e) {
            return new JsonResponse([
                'error'   => 'Translation failed',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
