<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default Pagination Per Page
    |--------------------------------------------------------------------------
    |
    | This value determines the default number of items per page for pagination.
    | You can override this in individual controllers as needed.
    |
    */
    'per_page' => env('PAGINATION_PER_PAGE', 50),
    
    /*
    |--------------------------------------------------------------------------
    | Admin Pagination Per Page
    |--------------------------------------------------------------------------
    |
    | Pagination settings for admin panel listings
    |
    */
    'admin_per_page' => env('ADMIN_PAGINATION_PER_PAGE', 25),
];

