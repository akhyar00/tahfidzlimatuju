<?php

// api/index.php
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';

// Set storage paths untuk Vercel
$app->useStoragePath('/tmp/storage');

// Override view path
$app->bind('path.storage', function() {
    return '/tmp/storage';
});

$app->bind('config', function() use ($app) {
    return $app['config'];
});

// Create storage directories
@mkdir('/tmp/storage', 0755, true);
@mkdir('/tmp/storage/framework', 0755, true);
@mkdir('/tmp/storage/framework/views', 0755, true);
@mkdir('/tmp/storage/framework/cache', 0755, true);

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$response->send();

$kernel->terminate($request, $response);