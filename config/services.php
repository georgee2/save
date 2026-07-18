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

    /*
    | ERPNext integration. DISABLED by default: while 'enabled' is false (or the
    | base_url is empty) the app binds the no-op CustomerSyncService and the ERP
    | webhook route returns 404 - zero impact on the live site. Turn on only when
    | the ERP team has delivered credentials + confirmed the field mapping.
    | Required to go live:
    |   ERPNEXT_ENABLED=true
    |   ERPNEXT_BASE_URL, ERPNEXT_API_KEY, ERPNEXT_API_SECRET, ERPNEXT_WEBHOOK_SECRET
    | Optional tuning:
    |   ERPNEXT_TIMEOUT (seconds), ERPNEXT_CACHE_TTL (seconds)
    | See documents/customer-portal/erp/ for the full integration guide.
    */
    'erpnext' => [
        // filter_var so the string "false" in .env is actually false (env() alone
        // returns the string, which is truthy in PHP and would incorrectly enable).
        'enabled' => filter_var(env('ERPNEXT_ENABLED', false), FILTER_VALIDATE_BOOLEAN),
        'base_url' => env('ERPNEXT_BASE_URL', ''),
        'api_key' => env('ERPNEXT_API_KEY', ''),
        'api_secret' => env('ERPNEXT_API_SECRET', ''),
        'webhook_secret' => env('ERPNEXT_WEBHOOK_SECRET', ''),
        'timeout' => (int) env('ERPNEXT_TIMEOUT', 8),
        'cache_ttl' => (int) env('ERPNEXT_CACHE_TTL', 300),
        // ERPNext usually requires Customer Group + Territory on create. Set these
        // to valid ERP values (confirm with the ERP team) so website-initiated
        // customer creation does not fail on mandatory fields. Sent only if set.
        'default_customer_group' => env('ERPNEXT_DEFAULT_CUSTOMER_GROUP', ''),
        'default_territory' => env('ERPNEXT_DEFAULT_TERRITORY', ''),
    ],

];
