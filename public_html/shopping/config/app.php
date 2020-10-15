<?php

//tietokantaan kirjautuminen
return [
    'database' => [
        'driver' => 'mysql',
        'host' => 'localhost',
        'dbname' => 'harhama_php_login_system',
        'username' => 'harhama_harhama',
        'password' => '&ynf7N1mG2GS'
    ],
    //Sähköpostivahvistus rekisteröinnille
    'mail' => [
        'transport' => 'smtp',
        'encrption' => 'tls',
        'port' => 587,
        'host' => 'smtp.gmail.com',
        'username' => 'your_gmail_email_address',
        'password' => 'your_gmail_password',
        'from' => 'no-reply@.com',
        'sender_name' => 'User Authentication'
    ]
];
