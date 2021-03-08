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
        $this->db = null;
    }

    private function executeQuery($query, $args = []) {
        $this->result = $this->db->prepare($query);
        $this->result->execute($args);
        return $this->result->rowCount();
    }

    public function insert($table, $object) {
        $args = [];
        $column = [];
        $query = "INSERT INTO {$table} SET ";
        foreach ($object as $col => $data) {
            $column[] = "`{$col}` = ?";
            $args[] = $data;

        }
        $query .= implode(', ', $column);
        return $this->executeQuery($query, $args);
    }

    public function delete($table, $condition = []) {
        if (count($condition) === 0) {
            return false;
        }
        $args = [];
        $where = [];
        $query = "DELETE FROM {$table} WHERE ";
        foreach ($condition as $col => $data) {
            $where[] = "`{$col}` = ?";
            $args[] = $data;
        }
        $query .= implode(', ', $where);
        return $this->executeQuery($query, $args);
    }

    public function update($table, $object, $condition = []) {
        if (count($condition) === 0) {
            return false;
        }
        $args = [];
        $column = [];
        $where = [];
        $query = "UPDATE {$table} SET ";
        foreach ($object as $col => $data) {
            $column[] = "`{$col}` = ?";
            $args[] = $data;
        }
        foreach ($condition as $col => $data) {
            $where[] = "`{$col}` = ?";
            $args[] = $data;
        }
        $query .= implode(', ', $column);
        $query .= " WHERE " . implode(' and ', $where);
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