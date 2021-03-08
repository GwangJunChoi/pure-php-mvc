<?php

namespace SimpleBoardApp\libraries;

class Request
{
    public $app;

    public function __construct($app) {
        $this->app = $app;
        if ($_SERVER['CONTENT_TYPE'] === 'application/json') {
            $data = json_decode(file_get_contents('php://input'),true);
            Request::setPost($data);
        }
    }

    public function getUri() {
        return $_SERVER['REQUEST_URI'];
    }

    public function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function post($key = '') {
        return ($key === '') ? $_POST : $_POST[$key];
    }

    public static function get($key = '') {
        return ($key === '') ? $_GET : $_GET[$key];
    }

    public static function setPost($args = []) {
        $_POST = $args;
    }

    public static function validate($validation) {
        foreach ($validation as $key => $value) {
            if ($value === 'require' && self::validateRequire(self::post($key))) {
                return false;
            }
        }
        return true;
    }

    private static function validateRequire($value) {
        return is_array($value) || !isset($value) || $value === "";
    }
}