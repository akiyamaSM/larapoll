<?php
return [
    'admin_auth' => env('LARAPOLL_ADMIN_AUTH_MIDDLEWARE', 'auth'),
    'admin_guard' => env('LARAPOLL_ADMIN_AUTH_GUARD', 'web'),
    'pagination' => env('LARAPOLL_PAGINATION', 15),
    'prefix' => env('LARAPOLL_PREFIX', 'admin_polls'),
    'results' => '',
    'radio' => '',
    'checkbox' => '',
    'user_model' => App\Models\Auth\User::class,
];
