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

    public function changePassword($user_id, $password) {
        $stmt = $this->_db->_pdo->prepare("UPDATE users SET user_password = :user_password WHERE user_id = :user_id");
        $stmt-> execute([
            ":user_id" => $user_id,
            ":user_password" => password_hash($password, PASSWORD_DEFAULT)
        ]);
    }
    public function changeUsername($user_id, $user_username) {
        $stmt = $this->_db->_pdo->prepare("UPDATE users SET user_username = :user_username WHERE user_id = :user_id");
        $stmt-> execute([
            ":user_id" => $user_id,
            ":user_username" => $user_username
        ]);
    }
    public function changeUsermail($user_id, $mail) {
        $stmt = $this->_db->_pdo->prepare("UPDATE users SET user_mail = :user_mail WHERE user_id = :user_id");
        $stmt-> execute([
            ":user_id" => $user_id,
            ":user_mail" => $mail
        ]);
    }
    public function changeUserFirstname($user_id, $user_firstname) {
        $stmt = $this->_db->_pdo->prepare("UPDATE users SET user_firstname = :user_firstname WHERE user_id = :user_id");
        $stmt-> execute([
            ":user_id" => $user_id,
            ":user_firstname" => $user_firstname
        ]);
    }
    public function changeUserLastname($user_id, $user_lastname) {
        $stmt = $this->_db->_pdo->prepare("UPDATE users SET user_lastname = :user_lastname WHERE user_id = :user_id");
        $stmt-> execute([
            ":user_id" => $user_id,
            ":user_lastname" => $user_lastname
        ]);
    }
    public function changeUserBirthdate($user_id, $user_birthdate) {
        $stmt = $this->_db->_pdo->prepare("UPDATE users SET user_birthdate = :user_birthdate WHERE user_id = :user_id");
        $stmt-> execute([
            ":user_id" => $user_id,
            ":user_birthdate" => $user_birthdate
        ]);
    }
    public function changeUserProfileBio($profile_bio, $user_id) {
        $stmt = $this->_db->_pdo->prepare("UPDATE profiles SET profile_bio = :profile_bio WHERE user_id = :user_id");
        $stmt-> execute([
            ":profile_bio" => $profile_bio,
            ":user_id" => $user_id
        ]);
    }
    public function changeProfileLocation($profile_location, $user_id) {
        $stmt = $this->_db->_pdo->prepare("UPDATE profiles SET profile_location = :profile_location WHERE user_id = :user_id");
        $stmt-> execute([
            ":profile_location" => $profile_location,
            ":user_id" => $user_id
        ]);
    }
    public function changeProfileActivity($profile_activity, $user_id) {
        $stmt = $this->_db->_pdo->prepare("UPDATE profiles SET profile_activity = :profile_activity WHERE user_id = :user_id");
        $stmt-> execute([
            ":profile_activity" => $profile_activity,
            ":user_id" => $user_id
        ]);
    }
}