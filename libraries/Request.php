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
}