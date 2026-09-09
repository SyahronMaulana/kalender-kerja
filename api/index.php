<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');

echo "Before Laravel<br>";

try {
    require __DIR__ . '/../public/index.php';

    echo "<br>After Laravel";
} catch (\Throwable $e) {
    echo "<h2>Laravel Error</h2>";
    echo "<pre>";
    echo $e->getMessage();
    echo "\n\nFILE: " . $e->getFile();
    echo "\nLINE: " . $e->getLine();
    echo "\n\nTRACE:\n" . $e->getTraceAsString();
    echo "</pre>";
}