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
        $count = $this->board->getCount();
        $boards = $this->board->getBoards([
            'offset' => (Request::get('offset')) ? Request::get('offset') : 0,
            'limit'  => (Request::get('limit')) ? Request::get('limit') : 10,
        ]);

        echo json_encode([
            'boards' => $boards,
            'total'  => $count,
        ]);
    }

    public function register() {
        $validation = Request::validate([
            'title' => 'require',
            'author' => 'require',
            'password' => 'require',
            'content' => 'require',
        ]);
        if (!$validation) {
            echo json_encode([
                'result' => false,
                'msg'    => 'validate false',
            ]);
            return false;
        }

        $board = [
            'title' => Request::post('title'),
            'author' => Request::post('author'),
            'password' => Request::post('password'),
            'content' => Request::post('content')
        ];
        $reulst = $this->board->create($board);
        echo json_encode([
            'result' => $reulst,
            'msg'    => ($reulst) ? 'success :)' : 'failed',
        ]);
    }

    public function getBoard($id) {
        echo json_encode($this->board->getBoard($id));
    }

    public function remove($id) {
        $validation = Request::validate([
            'password' => 'require',
        ]);
        if (!$validation) {
            echo json_encode([
                'result' => false,
                'msg'    => 'validate false',
            ]);
            return false;
        }
        $result = $this->board->remove($id, Request::post('password'));
        echo json_encode([
            'result' => $result,
            'msg'    => ($result) ? 'success :)' : 'failed'
        ]);
    }

    public function update($id) {
        $validation = Request::validate([
            'title' => 'require',
            'author' => 'require',
            'password' => 'require',
            'content' => 'require',
        ]);
        if (!$validation) {
            echo json_encode([
                'result' => false,
                'msg'    => 'validate false',
            ]);
            return false;
        }
        $board = [
            'title' => Request::post('title'),
            'author' => Request::post('author'),
            'password' => Request::post('password'),
            'content' => Request::post('content')
        ];

        $result = $this->board->update($board, $id);
        echo json_encode([
            'result' => $result,
            'msg'    => ($result) ? 'success :)' : 'failed',
        ]);
    }
}