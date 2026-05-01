<?php

$storagePath = $_ENV['LARAVEL_STORAGE_PATH'] ?? $_SERVER['LARAVEL_STORAGE_PATH'] ?? '/tmp/storage';

foreach ([
    $storagePath.'/app/public',
    $storagePath.'/framework/cache/data',
    $storagePath.'/framework/sessions',
    $storagePath.'/framework/views',
    $storagePath.'/logs',
] as $directory) {
    if (! is_dir($directory)) {
        mkdir($directory, 0775, true);
    }
}

$_ENV['LARAVEL_STORAGE_PATH'] = $storagePath;
$_SERVER['LARAVEL_STORAGE_PATH'] = $storagePath;
$_ENV['VIEW_COMPILED_PATH'] ??= $storagePath.'/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] ??= $storagePath.'/framework/views';

require __DIR__.'/../public/index.php';
