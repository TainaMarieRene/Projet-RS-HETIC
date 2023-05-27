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

    public function imgIsUse($img_type, $img){
        switch($img_type){
            case "profile_picture" :
                $stmt = $this->_db->_pdo->prepare("SELECT user_id FROM profiles WHERE profile_picture = :profile_img");
                $stmt->execute([
                    ":profile_img"=>$img
                ]);
                $check = $stmt->fetch(PDO::FETCH_ASSOC);
                break;
            case "profile_banner" :
                $stmt = $this->_db->_pdo->prepare("SELECT user_id FROM profiles WHERE profile_banner = :profile_img");
                $stmt->execute([
                    ":profile_img"=>$img
                ]);
                $check = $stmt->fetch(PDO::FETCH_ASSOC);
                break;
        }

        return ($check) ? true : false;
    }

    public function changeProfileImg($profile_type, $profile_img, $user_id){
        switch($profile_type){
            case "profile_picture":
                $stmt = $this->_db->_pdo->prepare("UPDATE profiles SET profile_picture = :profile_img WHERE user_id = :user_id");
                $stmt->execute([
                    ":profile_img" => $profile_img,
                    ":user_id" => $user_id
                ]);
                break;
            case "profile_banner":
                $stmt = $this->_db->_pdo->prepare("UPDATE profiles SET profile_banner = :profile_img WHERE user_id = :user_id");
                $stmt->execute([
                    ":profile_img" => $profile_img,
                    ":user_id" => $user_id
                ]);
                break;
        }
    }

    public function updateStatus($user_id, $type){
        $stmt = $this->_db->_pdo->prepare("UPDATE profiles SET profile_status = :type WHERE user_id = :user_id");
        $stmt->execute([
            ":user_id" => $user_id,
            ":type" => $type
        ]);
    }
}