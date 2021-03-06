<?php

namespace App\Controller;

use \App\Model\Board;

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
        echo json_encode($this->board->create());
    }

    public function getBoard($id) {
        echo json_encode($this->board->getBoard($id));
    }

    public function remove($id) {
        echo json_encode($this->board->remove($id));
    }

    public function update($id) {
        echo 'update';
    }

}