<?php

namespace Users;

require_once '../Models/Database.php';
use Database\Database;
use PDO;
use PDOException;

class User {
    private Database $_db;

    public function __construct(){
        $this->_db = new Database;
    }

    public function createUser($firstname, $lastname, $birthdate, $username, $mail, $password){
        $stmt = $this->_db->_pdo->prepare("INSERT INTO users (user_username, user_mail, user_password, user_firstname, user_lastname, user_birthdate) VALUES (:user_username, :user_mail, :user_password, :user_firstname, :user_lastname, :user_birthdate)");
        $stmt->execute([
            ":user_username" => $username,
            ":user_mail" => $mail,
            ":user_password" => password_hash($password, PASSWORD_DEFAULT),
            ":user_firstname" => $firstname,
            ":user_lastname" => $lastname,
            ":user_birthdate" => $birthdate
        ]);

        return $this->getUser($mail);
    }

    public function deleteUser($user_id){
        $stmt = $this->_db->_pdo->prepare("DELETE FROM users WHERE user_id = :user_id");
        $stmt->execute([
            ":user_id" => $user_id
        ]);
    }

    public function loginUser($mail, $password){
        $stmt = $this->_db->_pdo->prepare("SELECT user_password FROM users WHERE user_mail = :user_mail");
        $stmt->execute([
            ":user_mail" => $mail
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return password_verify($password, $user["user_password"]);
    }

    public function getUser($mail){
        $stmt = $this->_db->_pdo->prepare("SELECT user_id, user_username FROM users WHERE user_mail = :user_mail");
        $stmt->execute([
            ":user_mail" => $mail
        ]);
        
        return $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserByID($user_id){
        $stmt = $this->_db->_pdo->prepare("SELECT * FROM users WHERE user_id = :user_id");
        $stmt->execute([
            ":user_id" => $user_id
        ]);
        
        return $user = $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function checkUsername($username){
        $stmt = $this->_db->_pdo->prepare("SELECT user_username FROM users WHERE user_username = :username");
        $stmt->execute([
            ":username" => $username
        ]);
        $check = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($check) ? true : false;
    }

    public function checkMail($mail){
        $stmt = $this->_db->_pdo->prepare("SELECT user_mail FROM users WHERE user_mail = :mail");
        $stmt->execute([
            ":mail" => $mail
        ]);
        $check = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($check) ? true : false;
    }

    public function updateStatus($user_id, $type){
        $checkAccountStatus = $this->getUserByID($user_id);

        if(($checkAccountStatus["user_account_status"] == 'waiting' && $type == 'valid') || ($checkAccountStatus["user_account_status"] == 'valid' && $type == 'disable') || ($checkAccountStatus["user_account_status"] == 'disable' && $type == 'valid')){
            $stmt = $this->_db->_pdo->prepare("UPDATE users SET user_account_status = :type WHERE user_id = :user_id");
            $stmt->execute([
                ":user_id" => $user_id,
                ":type" => $type
            ]);
        }
    }

    public function updateLastSeen($user_id){
        $stmt = $this->_db->_pdo->prepare("UPDATE users SET user_last_seen = :time WHERE user_id = :user_id");
        $stmt->execute([
            ":time" => date("Y-m-d G:i:s", time()),
            ":user_id" => $user_id
        ]);
    }
}

// TEMPO : MG
function getUserName($user_id) {

    $pdo = db();

    $requete = $pdo->prepare("SELECT
    user_firstname, user_lastname, user_username
    FROM users
    WHERE user_id = :user_id;
    ");

    $requete->execute([
        ":user_id"=>$user_id
    ]);

    $result = $requete->fetch(PDO::FETCH_ASSOC);

    return $result;
}