<?php

namespace Users;
use PDO;
use PDOException;
use Database\DB;

class User {
    private DB $_db;

    public function __construct($db){
        $this->_db = $db;
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

    public function addUser($firstname, $lastname, $birthdate, $username, $mail, $password){
        // Création de l'user dans la table users
        $stmt = $this->_db->_pdo->prepare("INSERT INTO users (user_username, user_mail, user_password, user_firstname, user_lastname, user_birthdate) VALUES (:user_username, :user_mail, :user_password, :user_firstname, :user_lastname, :user_birthdate)");
        $stmt->execute([
            ":user_username" => $username,
            ":user_mail" => $mail,
            ":user_password" => password_hash($password, PASSWORD_DEFAULT),
            ":user_firstname" => $firstname,
            ":user_lastname" => $lastname,
            ":user_birthdate" => $birthdate
        ]);

        // Création de l'user dans la table profiles grâce à l'user_id
        $stmt = $this->_db->_pdo->prepare("SELECT user_id FROM users WHERE user_username = :user_username");
        $stmt->execute([
            ":user_username" => $username 
        ]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $stmt = $this->_db->_pdo->prepare("INSERT INTO profiles (user_id) VALUES (:user_id)");
        $stmt->execute([
            ":user_id" => $user["user_id"]
        ]);
    }
}
