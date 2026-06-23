<?php

ini_set('display_errors', '1');
error_reporting(E_ALL);
// 1. Siapkan folder sementara di /tmp yang berstatus read-write untuk Laravel
$storageFolders = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/bootstrap/cache',
];

foreach ($storageFolders as $folder) {
    if (!is_dir($folder)) {
        mkdir($folder, 0755, true);
    }
}

// 2. Jalankan bootstrap Laravel secara manual
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// 3. Paksa Laravel menggunakan /tmp untuk mendaur ulang cache dan views
$app->useStoragePath('/tmp/storage');

// 4. Proses request yang masuk
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();
$kernel->terminate($request, $response);
