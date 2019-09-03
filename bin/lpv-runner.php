#!/usr/bin/env php
<?php
exec("lpv --version", $output, $existenceStatusCode);

if ($existenceStatusCode !== 0) {
    echo 'The lpv binary is not available.';
    exit(1);
}

if (count($argv) === 1) {
    echo 'Running lpv validate.' . PHP_EOL;
    exec("lpv validate", $output, $statusCode);
    exit($statusCode);
}

if ($argv[1] === '-v') {
    $lpvFileCommand = 'lpv validate -v';
    $lpvGlobFileCommand = 'lpv validate -v --glob-pattern ' . $argv[2];
} else {
    $lpvFileCommand = 'lpv validate';
    $lpvGlobFileCommand = 'lpv validate --glob-pattern ' . $argv[2];
}

if ($argv[2] === "use-lpv-file") {
    echo 'Running ' . $lpvFileCommand . '.' . PHP_EOL;
    exec($lpvFileCommand, $output, $statusCode);
} else {
    echo 'Running ' . $lpvGlobFileCommand . PHP_EOL;
    exec($lpvGlobFileCommand, $output, $statusCode);
}

exit($statusCode);
