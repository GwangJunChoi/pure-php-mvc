<?php

namespace SimpleBoardApp\libraries;

use PDO;

class Model
{
    protected $db;
    protected $result;

    public function __construct() {
        $dsn = "mysql:host=".ENV['DB_HOST'].";dbname=".ENV['DB_DATABASE'];
        $user = ENV['DB_USERNAME'];
        $passwd = ENV['DB_PASSWORD'];
        $this->db = new PDO($dsn, $user, $passwd);
    }

    public function __destruct() {
        //$db = null;
    }

    private function executeQuery($query, $args = []) {
        $this->result = $this->db->prepare($query);
        return $this->result->execute($args);
    }

    public function insert($query, $args = []) {
        return $this->executeQuery($query, $args);
    }

    public function delete($query, $args = []) {
        return $this->executeQuery($query, $args);
    }

    public function update($query, $args = []) {
        return $this->executeQuery($query, $args);
    }

    public function query($query, $args = []) {
        $this->executeQuery($query, $args);
        return $this;
    }

    public function getRows() {
        return $this->result->fetchAll(PDO::FETCH_OBJ);
    }

    public function getRow() {
        return $this->result->fetch(PDO::FETCH_OBJ);
    }
}