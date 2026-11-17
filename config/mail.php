<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pengiriman email
    |--------------------------------------------------------------------------
    | Bila MAIL_HOST diisi, email dikirim lewat SMTP (disarankan).
    | Bila kosong, dipakai fungsi mail() bawaan PHP (sering masuk spam /
    | dinonaktifkan di hosting gratis).
    |
    | MAIL_ENCRYPTION: tls (STARTTLS, port 587) | ssl (port 465) | kosong.
    */

    'host'         => env('MAIL_HOST', ''),
    'port'         => (int) env('MAIL_PORT', 587),
    'encryption'   => env('MAIL_ENCRYPTION', 'tls'),
    'username'     => env('MAIL_USERNAME', ''),
    'password'     => env('MAIL_PASSWORD', ''),
    'from_address' => env('MAIL_FROM_ADDRESS', ''),
    'from_name'    => env('MAIL_FROM_NAME', env('APP_NAME', 'NEXLIB')),
    'timeout'      => 15,

];
