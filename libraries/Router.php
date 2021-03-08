<?php

namespace SimpleBoardApp\libraries;

class Router
{
    public $app;

    private $routes = [];

    private $currentUri;

    private $currentPath;

    private const CONTROLLER_SPLITTER = '@';

    public function __construct ($app) {
        $this->app = $app;
        $this->currentUri = $this->app->request->getUri();
        $this->setCurrentPath();
        return $this;
    }

    private function setCurrentPath() {
        $parsed_url = parse_url($this->currentUri);
        $this->currentPath = (isset($parsed_url['path'])) ? $parsed_url['path'] : '/';
    }

    private function addRoutes($method, $expression, $callback) {
        array_push($this->routes, [
            'expression' => $expression,
            'callback' => $callback,
            'method' => $method
        ]);
    }

    public function get($uri, $callback) {
        $this->addRoutes('GET', $uri, $callback);
    }

    public function post($uri, $callback) {
        $this->addRoutes('POST', $uri, $callback);
    }

    public function delete($uri, $callback) {
        $this->addRoutes('DELETE', $uri, $callback);
    }

    public function patch($uri, $callback) {
        $this->addRoutes('PATCH', $uri, $callback);
    }

    public function put($uri, $callback) {
        $this->addRoutes('PUT', $uri, $callback);
    }

    private function getMatchedUri($routerUri) {
        $routerUri = '^' . $routerUri . '$';
        if (preg_match('#' . $routerUri . '#', $this->currentPath, $matches)) {
            array_shift($matches);
            //print_r($matches);
            return $matches;
        }
        return false;
    }

    private function isMethodMatched($routerMethod) {
        return strtolower($this->app->request->getRequestMethod()) === strtolower($routerMethod);
    }

    private function parseController($controller) {
        return explode(self::CONTROLLER_SPLITTER, $controller);
    }

    //https://wordpress.pplane.net/2020/02/22/php%EB%A1%9C-%EA%B0%84%EB%8B%A8%ED%95%98%EA%B3%A0-%EC%9A%B0%EC%95%84%ED%95%9C-url-%EB%9D%BC%EC%9A%B0%ED%8C%85/
    public function callAction($basepath = '/') {
        foreach ($this->routes as $route) {
            $this->getMatchedUri($route['expression']);
            $args = $this->getMatchedUri($route['expression']);
            if (is_array($args) && $this->isMethodMatched($route['method'])) {
                if (is_callable($route['callback'])) {
                    call_user_func_array($route['callback'], $args);
                    exit;
                }

                list($controller, $method) = $this->parseController($route['callback']);
                $controller = "\App\Controller\\".$controller;
                $controller =  new $controller;
                call_user_func_array(array($controller, $method), $args);
                exit;
            }
        }

        header("HTTP/1.0 404 Not Found");
        exit;
    }
}