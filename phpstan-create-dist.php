<?php
$tmp = explode(DIRECTORY_SEPARATOR, __DIR__);

$hunt  = 'Menu';
$base  = 'gcphpstan_'.$hunt;
$index = array_search($hunt, $tmp);

$instance = $tmp[$index - 2];
$worker   = $tmp[$index - 3];

$binpath = __DIR__.'/vendor/bin/phpstan';
$output  = shell_exec($binpath.' --version');
$output  = trim($output??'');
$tmp     = explode(' ',$output);
$version = array_pop($tmp);

$path = "/tmp/{$base}/{$worker}-{$instance}-{$version}/";

echo PHP_EOL;
echo 'CONFIGURED TEMP PATH: ',$path,PHP_EOL;
echo PHP_EOL;

if(!is_dir('/tmp/'.$base)) {
    mkdir('/tmp/'.$base);
}
if(!is_dir($path)) {
    mkdir($path);
}

$dirs = array_filter(glob("/tmp/{$base}/*"), 'is_dir');
print_r($dirs);


// Neon files REQUIRE actual tabs...
$contents  = 'parameters:'.PHP_EOL;
$contents .= "\t".'tmpDir: '.$path.PHP_EOL;
$contents .= PHP_EOL;

file_put_contents(__DIR__.DIRECTORY_SEPARATOR.'phpstan.neon.dist', $contents);


