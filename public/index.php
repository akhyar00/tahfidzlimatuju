<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Cek apakah sedang berjalan di Vercel
if (isset($_ENV['VERCEL'])) {
    // Jika YA, gunakan file bootstrap khusus Vercel
    $app = require_once __DIR__.'/../bootstrap/vercel.php';
} else {
    // Jika TIDAK (di Codespaces), gunakan file bootstrap normal
    $app = require_once __DIR__.'/../bootstrap/app.php';
}

// Kode di bawah ini menangani permintaan masuk
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);