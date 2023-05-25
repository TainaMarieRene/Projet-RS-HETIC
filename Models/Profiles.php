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

    public function createProfile($user){
        $stmt = $this->_db->_pdo->prepare("INSERT INTO profiles (user_id) VALUES (:user_id)");
        $stmt->execute([
            ":user_id" => $user["user_id"]
        ]);
    }

    public function deleteProfile($user_id){
        $stmt = $this->_db->_pdo->prepare("DELETE FROM profiles WHERE user_id = :user_id");
        $stmt->execute([
            ":user_id" => $user_id
        ]);
    }

    public function getProfileInfo($user_id) {
        $stmt = $this->_db->_pdo->prepare("SELECT * FROM profiles WHERE user_id = :user_id");
        $stmt->execute([
            ":user_id"=>$user_id
        ]);
        $profile = $stmt->fetch(PDO::FETCH_ASSOC);
    
        return $profile;
    }
}