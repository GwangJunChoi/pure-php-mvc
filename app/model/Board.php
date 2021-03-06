<?php

namespace App\Model;

use \SimpleBoardApp\libraries\Model;

class Board extends Model
{
    public function __construct() {
        parent::__construct();
    }

    public function getAll() {
        $query = "SELECT * FROM simplae_board WHERE is_deleted = 0";
        return $this->query($query)->getRows();
    }

    public function register($id) {
        return $this->insert();
    }

    public function getBoard($id) {
        $query = "SELECT * FROM simplae_board WHERE is_deleted = 0 and id = ?";
        return $this->query($query , [$id])->getRow();
    }

    public function delete() {
        return $this->delete();
    }


}