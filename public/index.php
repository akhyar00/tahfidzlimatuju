<?php

use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

// Cek apakah sedang berjalan di Vercel
if (isset($_ENV['VERCEL'])) {
    // Jika YA, gunakan file bootstrap khusus Vercel
    require_once __DIR__.'/../bootstrap/vercel.php';
}

// Register Composer autoloader
require __DIR__.'/../vendor/autoload.php';

// Bootstrap Laravel dan tangani permintaan
(require_once __DIR__.'/../bootstrap/app.php')
    ->handleRequest(Request::capture());