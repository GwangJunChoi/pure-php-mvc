<?php
define('ENV', parse_ini_file(__DIR__.'/.env'));
if (ENV['DEV'] === 'true') {
    error_reporting(E_ALL);
    ini_set("display_errors","On");
}
require __DIR__.'/BoardApplication.php';
$app = new \simpleBoardApp\BoardApplication();


//print_r($_SERVER);
$app->run();