<?php

// File: bootstrap/vercel.php

use Illuminate\Foundation\Application;

$app = require __DIR__.'/app.php';

// Beritahu Laravel untuk menggunakan folder /tmp untuk semua penyimpanan file.
$app->useStoragePath('/tmp/storage');

return $app;