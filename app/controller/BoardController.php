<?php

namespace App\Controller;

use \App\Model\Board;
use SimpleBoardApp\libraries\Request;

class BoardController
{
    private $board;

    public function __construct() {
        $this->board = new Board();
    }

    public function index() {
        echo json_encode($this->board->getAll());
    }

    public function register() {
        //ajax register

        echo json_encode($this->board->create());
    }

    public function getBoard($id) {
        print_r(Request::class);
        print_r($id);
        echo 'view';
    }

    public function delete($id) {
        echo 'delete';
    }

    public function update($id) {
        echo 'update';
    }

}