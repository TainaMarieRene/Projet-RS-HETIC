<?php

namespace Profiles;
require_once '../Models/Database.php';
use Database\Database;
use PDO;
use PDOException;

class Profile {

    private Database $_db;

    public function __construct(){
        $this->_db = new Database;
    }

    public function creatProfile($user){
        $stmt = $this->_db->_pdo->prepare("INSERT INTO profiles (user_id) VALUES (:user_id)");
        $stmt->execute([
            ":user_id" => $user["user_id"]
        ]);
    }

}