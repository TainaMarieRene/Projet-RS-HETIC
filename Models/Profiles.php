<?php

namespace Profiles;
use PDO;
use PDOException;
use Database\DB;

class Profile {

    private DB $_db;

    public function __construct($db){
        $this->_db = $db;
    }

    public function creatProfile($user){
        $stmt = $this->_db->_pdo->prepare("INSERT INTO profiles (user_id) VALUES (:user_id)");
        $stmt->execute([
            ":user_id" => $user["user_id"]
        ]);
    }

}