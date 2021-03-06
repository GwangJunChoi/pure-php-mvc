<?php
error_reporting(E_ALL);
ini_set("display_errors","On");
define('ENV', parse_ini_file(__DIR__.'/.env'));

require __DIR__.'/BoardApplication.php';
$app = new \simpleBoardApp\BoardApplication();


//print_r($_SERVER);
$app->run();