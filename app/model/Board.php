<?php

namespace App\Model;

use \SimpleBoardApp\libraries\Model;

class Board extends Model
{
    public function __construct() {
        parent::__construct();
    }

    public function getCount() {
        $query = "SELECT count(*) as total FROM simplae_board WHERE is_deleted = 0";
        return $this->query($query)->getRow()->total;
    }

    public function getBoards($page) {
        $offset = intval($page['offset']);
        $limit = intval($page['limit']);
        $query = "SELECT title, author, content, inserted_at
                    FROM simplae_board 
                    WHERE is_deleted = 0 ORDER BY id DESC LIMIT {$offset}, {$limit}";
        return $this->query($query)->getRows();
    }

    public function create($board) {
        return $this->insert("simplae_board" , $board);
    }

    public function getBoard($id) {
        $query = "SELECT title, author, content, inserted_at FROM simplae_board WHERE is_deleted = 0 and id = ?";
        return parent::query($query , [$id])->getRow();
    }

    public function remove($id, $password) {
        $update = ['is_deleted' => 1];
        $condition = [
            'id' => $id,
            'password' => $password
        ];
        return parent::update('simplae_board', $update, $condition);
    }

    public function update($board, $id) {
        $condition = [
            'id' => $id,
            'password' => $board['password']
        ];
        return parent::update('simplae_board', $board, $condition);
    }
}