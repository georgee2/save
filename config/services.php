<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    /*
    | reCAPTCHA v3 (Google). Verification is skipped entirely when secret_key is
    | empty and always skipped in the local environment (see RecaptchaService).
    | Required in production .env:
    |   RECAPTCHA_SITE_KEY, RECAPTCHA_SECRET_KEY
    | Optional:
    |   RECAPTCHA_MIN_SCORE        (default 0.5) - registration / email forms
    |   RECAPTCHA_LOGIN_MIN_SCORE  (default 0.3) - login step-up; more lenient so
    |                              real staff are never locked out on a low score.
    | Infra note: put Cloudflare (WAF + Bot Fight Mode + rate rules) in front for
    | the highest ROI; Turnstile can later replace reCAPTCHA. Both are dashboard
    | changes, out of application-code scope.
    */
    'recaptcha' => [
        'site_key' => env('RECAPTCHA_SITE_KEY', ''),
        'secret_key' => env('RECAPTCHA_SECRET_KEY', ''),
        'min_score' => env('RECAPTCHA_MIN_SCORE', 0.5),
        'login_min_score' => env('RECAPTCHA_LOGIN_MIN_SCORE', 0.3),
    ],

];
