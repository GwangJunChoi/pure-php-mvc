<?php
namespace SimpleBoardApp;

use SimpleBoardApp\libraries\Request;
use SimpleBoardApp\libraries\Router;

class BoardApplication
{
    public $router;
    public $request;

    private $libraries = [
        'Router.php',
        'Database.php',
        'Request.php',
        'Model.php',
    ];

    public function __construct() {
        $this->loadLibraries();
        $this->loadHeler();
        $this->autoLoad();
        $this->request = new Request($this);
        $this->router = new Router($this);
        require_once __DIR__.'/routes.php';
    }

    private function loadHeler() {
        require_once __DIR__ . '/helper.php';
    }

    private function autoLoad() {
        foreach (glob(__DIR__ . "/app/controller/*.php") as $filename) {
            require_once $filename;
        }
        foreach (glob(__DIR__ . "/app/model/*.php") as $filename) {
            require_once $filename;
        }
    }

    private function loadLibraries() {
        try {
            foreach ($this->libraries as $library) {
                if (!file_exists( __DIR__ . '/libraries/' . $library)) {
                    throw new \Exception('library file not exists ' . $library);
                }
                require_once __DIR__ . '/libraries/' . $library;
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            exit;
        }
    }

    public function run() {
        $this->router->callAction();
    }
}