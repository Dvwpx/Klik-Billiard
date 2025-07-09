<?php

return [
    'cloud_name' => env('CLOUDINARY_CLOUD_NAME'),
    'api_key' => env('CLOUDINARY_API_KEY'),
    'api_secret' => env('CLOUDINARY_API_SECRET'),
    'secure_url' => env('CLOUDINARY_SECURE_URL', true),
    'file_upload' => [
        'overwrite' => false,
        'notify_url' => null,
        'async' => false,
        'backup' => false,
    ],
    // Tambahkan konfigurasi timeout
    'timeout' => 300, // 5 menit
    'connect_timeout' => 60, // 1 menit untuk koneksi
];
