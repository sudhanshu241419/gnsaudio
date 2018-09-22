<?php

class Db {

    public $pdo;
    public function __construct() {
        try {
            $this->pdo = new PDO('mysql:host=localhost;dbname=' . DB_DATABASE, 'root', 'abc@123');
        } catch (PDOException $e) {
            echo 'Error: ' . $e->getMessage();
            exit();
        }
    }

}
