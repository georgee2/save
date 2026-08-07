<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Public inquiry forms
    |--------------------------------------------------------------------------
    |
    | The "schedule a tour" and "request info" widgets on offer and project
    | detail pages. When a pair is off, the page renders the contact card
    | (phone / WhatsApp / email / link to the contact page) instead.
    |
    | These are read through config() rather than env() directly in the blades:
    | env() returns null once `php artisan config:cache` has run, which would
    | leave the flags permanently stuck off and impossible to switch on.
    |
    */

    'offers' => [
        'schedule_tour' => env('OFFERS_SCHEDULE_TOUR', false),
        'request_info' => env('OFFERS_REQUEST_INFO', false),
    ],

    'projects' => [
        'schedule_tour' => env('PROJECTS_SCHEDULE_TOUR', false),
        'request_info' => env('PROJECTS_REQUEST_INFO', false),
    ],

];
