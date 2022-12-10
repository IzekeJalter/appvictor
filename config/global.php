<?php
return [
    'password' => [
        'super_admin' => env('SUPER_ADMIN_PASSWORD'),
        'admin' => env('ADMIN_PASSWORD'),
        'subscriber' => env('SUBSCRIBER_PASSWORD'),
        'client' => env('CLIENT_PASSWORD'),
    ],
    'roles' => [
        'super_admin' => 'Super Admin',
        'admin' => 'Admin',
        'subscriber' => 'Subscriber',
        'client' => 'Client',
    ],
    'twilio' => [
        'sid' => env('TWILIO_ACCOUNT_SID'),
        'token' => env('TWILIO_AUTH_TOKEN'),
        'phone_code' => env('PHONE_CODE'),
        'from' => env('TWILIO_FROM'),
    ],
    'emails' => [
        'dev' => env('DEV_EMAIL'),
    ],
    'important' => [
        'ipfinal'   => 'http://io.adafruit.com',
        'userIO'    => 'Victor_Almanza',
        'keyIO'     => 'aio_gOoW15GYVt9wbvc3PGYp1oXM3fKS',
        'group_key' => 'finalproyect'
    ]
];
?>