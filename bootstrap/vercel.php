<?php
// bootstrap/vercel.php

// Load autoloader
require_once __DIR__.'/../vendor/autoload.php';

// Set basic environment for Vercel
putenv('VIEW_COMPILED_PATH=/tmp');
putenv('APP_STORAGE=/tmp'); 
putenv('CACHE_DRIVER=array');
putenv('SESSION_DRIVER=array');

// Create /tmp directory
@mkdir('/tmp', 0755, true);

// Load the original Laravel bootstrap
$app = require_once __DIR__.'/app.php';

// Override storage path to /tmp
$app->useStoragePath('/tmp');

return $app;