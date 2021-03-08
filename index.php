<?php
define('ENV', parse_ini_file(__DIR__.'/.env'));
if (ENV['DEV'] === 'TRUE') {
    error_reporting(E_ALL);
    ini_set("display_errors","On");
}
if (empty(ENV['DB_DATABASE'])) {
    echo 'require database info';
    exit;
}
require __DIR__.'/BoardApplication.php';
$app = new \simpleBoardApp\BoardApplication();

$app->run();