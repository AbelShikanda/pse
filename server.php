<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Laravel PHP Built-in Server
|--------------------------------------------------------------------------
*/

$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

$paths = [
    __DIR__.'/public'.$uri,
    __DIR__.'/public'.rtrim($uri, '/').'/index.php',
];

foreach ($paths as $path) {
    if ($uri !== '/' && file_exists($path) && ! is_dir($path)) {
        return false;
    }
}

chdir(__DIR__.'/public');

$testFile = $uri.'/index.php';

if (file_exists($testFile)) {
    $uri = $testFile;
} else {
    $uri = '/index.php';
}

$_SERVER['SCRIPT_NAME'] = $uri;
$_SERVER['SCRIPT_FILENAME'] = '.'.$uri;

require_once __DIR__.'/public/index.php';
