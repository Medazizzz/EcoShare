# EcoShare - AI Auto Description (Hugging Face)

## What it does
When creating a **Publicité** with an empty **Description**, the app generates a short eco-friendly description via Hugging Face Inference API.
The saved text is plain text, so it can be translated later using Google Translate API.

## Setup
1. Copy `.env.local.example` to `.env.local`
2. Fill:
   - `MAILER_DSN` (Gmail SMTP with an app password)
   - `MAILER_FROM`, `APP_PUBLICITE_NOTIFICATION_EMAIL`
   - `HUGGINGFACE_API_KEY`

## Run
```bash
composer install
php bin/console cache:clear
php -S 127.0.0.1:8000 -t public
```

## Test
Go to `/publicite/new`, leave **Description** empty, submit.
