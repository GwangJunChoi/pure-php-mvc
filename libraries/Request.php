<?php

namespace SimpleBoardApp\libraries;

class Request
{
    public $app;

    public function __construct($app) {
        $this->app = $app;
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
}