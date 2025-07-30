<?php
// bootstrap/vercel.php

// Load Composer autoloader first
require_once __DIR__.'/../vendor/autoload.php';

// Set environment variables for Vercel
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_ENV['APP_STORAGE'] = '/tmp';
$_ENV['CACHE_DRIVER'] = 'array';
$_ENV['SESSION_DRIVER'] = 'array';
$_ENV['LOG_CHANNEL'] = 'stderr';

// Create required directories in /tmp
$dirs = ['/tmp/views', '/tmp/storage', '/tmp/storage/app', '/tmp/storage/framework', '/tmp/storage/framework/cache', '/tmp/storage/framework/sessions', '/tmp/storage/framework/views', '/tmp/storage/logs'];

foreach ($dirs as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0755, true);
    }
}

// Load Laravel application
$app = require_once __DIR__.'/app.php';

// Override storage path
$app->useStoragePath('/tmp/storage');

// Bind view paths
$app->singleton('path.storage', function() {
    return '/tmp/storage';
});

$app->singleton('files', function() {
    return new \Illuminate\Filesystem\Filesystem;
});

return $app;