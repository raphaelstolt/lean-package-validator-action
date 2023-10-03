#!/usr/bin/env php
<?php
exec("lpv --version", $output, $existenceStatusCode);

$options = getopt('h', ['directory:', 'help']);
$verbose = false;

$help = <<<HELP
This command delegates the GitHub action to the lpv binary:

Usage:
  lpvrunner.php [-hv] [--help|--directory=<directory-to-scan>]

Options:
  --directory <directory>  The directory to scan
  -v                       Increases the verbosity of messages
  -h, --help               Displays this help message

HELP;

if (array_key_exists('h', $options) || array_key_exists('help', $options)) {
    echo $help;
    exit(0);
}

if ($existenceStatusCode !== 0) {
    echo 'The lpv binary is not available.';
    exit(1);
}

if (!array_key_exists('directory', $options)) {
    echo 'The directory to scan has not been provided. See --help.' . PHP_EOL;
    exit(1);
}

$directoryToScan = $options['directory'];

if (file_exists($directoryToScan) === false) {
    echo "The provided directory [$directoryToScan] to scan doesn't exist." . PHP_EOL;
    exit(1);
}

if (array_key_exists('v', $options)) {
    $verbose = true;
}

if (count($argv) === 1) {
    echo "Running lpv validate $directoryToScan." . PHP_EOL;
    exec("lpv validate $directoryToScan", $output, $statusCode);
    exit($statusCode);
}

$lpvCommand = "lpv validate $directoryToScan";
if (isset($argv[3]) && $argv[3] !== "use-lpv-file") {
    $lpvCommand = "lpv validate --glob-pattern " . $argv[3] . " $directoryToScan";
}

if ($verbose) {
    $lpvCommand = "lpv validate -v $directoryToScan";
    if (isset($argv[3]) && $argv[3] !== "use-lpv-file") {
        $lpvCommand = "lpv validate -v --glob-pattern " . $argv[3] . " $directoryToScan";
    }
}

echo 'Running ' . $lpvCommand . '.' . PHP_EOL;
exec($lpvCommand, $output, $statusCode);
var_dump($output);

exit($statusCode);
