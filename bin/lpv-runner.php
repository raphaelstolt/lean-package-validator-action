#!/usr/bin/env php

<?php

\exec("lpv --version 2> /dev/null", $output, $existenceStatusCode);

if ($existenceStatusCode !== 0) {
    echo 'The lpv binary is not available.' . PHP_EOL;
    exit(1);
}

$options = \getopt('h', ['directory:', 'help']);
$verbose = false;

$help = <<<HELP
This command delegates the GitHub action to the lpv binary:

Usage:
  lpvrunner.php [-hv] [--help|--directory=<directory-to-scan>] verbose=false glob-pattern=use-lpv-file

Options:
  --directory <directory>  The directory to scan
  -h, --help               Displays this help message

HELP;

if (\array_key_exists('h', $options) || \array_key_exists('help', $options)) {
    echo $help;
    \exit(0);
}

if (!\array_key_exists('directory', $options)) {
    echo 'The directory to scan has not been provided. See --help.' . PHP_EOL;
    \exit(1);
}

$directoryToScan = $options['directory'];

if (\file_exists($directoryToScan) === false) {
    echo "The provided directory [$directoryToScan] to scan doesn't exist." . PHP_EOL;
    \exit(1);
}

$lpvCommand = "lpv validate $directoryToScan";

// verbosity
if (isset($argv[3]) && $argv[3] == 'true') {
    $lpvCommand = "lpv validate -v $directoryToScan";
}

// glob pattern or .lpv file in repository
if (isset($argv[4]) && $argv[4] !== 'use-lpv-file') {
    $lpvCommand.= " --glob-pattern " . trim($argv[4]);
}

echo 'Running ' . $lpvCommand . '.' . PHP_EOL;
\exec($lpvCommand . ' 2> /dev/null', $output, $statusCode);

foreach ($output as $outputLine) {
    echo $outputLine . PHP_EOL;
}

if ($statusCode !== 0) {
    echo 'Running ' . $lpvCommand .  ' failed.' . PHP_EOL;
}

exit($statusCode);
