<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);

// 1. Siapkan folder sementara di /tmp yang berstatus read-write
$storageFolders = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/bootstrap/cache',
    '/tmp/storage/logs',
];

foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// 2. Load autoload dan bootstrap Laravel
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Paksa Laravel menggunakan /tmp sebagai folder storage
$app->useStoragePath('/tmp/storage');

// 4. Proses request yang masuk (Arsitektur Baru Laravel 11+)
$app->handleRequest(Illuminate\Http\Request::capture());
