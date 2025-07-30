<?php
// bootstrap/vercel.php

// Set paths for Vercel
$_ENV['VIEW_COMPILED_PATH'] = '/tmp/views';
$_ENV['APP_STORAGE'] = '/tmp';
$_ENV['CACHE_DRIVER'] = 'array';
$_ENV['SESSION_DRIVER'] = 'array';

// Create required directories
if (!file_exists('/tmp/views')) {
    mkdir('/tmp/views', 0755, true);
}
if (!file_exists('/tmp/storage')) {
    mkdir('/tmp/storage', 0755, true);
}

// Load original bootstrap
$app = require_once __DIR__.'/app.php';

return $app;