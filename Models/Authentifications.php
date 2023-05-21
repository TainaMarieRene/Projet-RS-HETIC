<?php

namespace Authentifications;

require_once '../Models/Database.php';
use Database\Database;
use PDO;
use PDOException;

class Authentification {
    private Database $_db;

    public function __construct(){
        $this->_db = new Database;
    }

    public function createToken($user){
        $token = bin2hex(random_bytes(15)) . time();
        $stmt = $this->_db->_pdo->prepare("INSERT INTO authentifications (user_id, user_username, user_agent, user_token, user_token_start, user_token_end) VALUES (:user_id, :user_username, :user_agent, :token, :token_start, :token_end)");
        $stmt->execute([
            ":user_id" => $user["user_id"],
            ":user_username" => $user["user_username"],
            ":user_agent" => $_SERVER['HTTP_USER_AGENT'],
            ":token" => password_hash($token, PASSWORD_DEFAULT),
            ":token_start" => date("Y-m-d G:i:s", time()),
            ":token_end" => date("Y-m-d G:i:s", time() + (30*24*60*60))
        ]);

        return $token;
    }

    public function deleteToken($user_username, $user_agent){
        $stmt = $this->_db->_pdo->prepare("DELETE FROM authentifications WHERE user_username = :user_username AND user_agent = :user_agent");
        $stmt->execute([
            ":user_username" => $user_username,
            ":user_agent" => $user_agent
        ]);
    }

    public function areLogin($uniCookieUsername, $uniCookieAgent, $uniCookieToken){
        if($uniCookieUsername && $uniCookieAgent && $uniCookieToken){
            $stmt = $this->_db->_pdo->prepare("SELECT user_token FROM authentifications WHERE user_username = :user_username AND user_agent = :user_agent");
            $stmt->execute([
                ":user_username" => $uniCookieUsername,
                ":user_agent" => $uniCookieAgent
            ]);
            $token = $stmt->fetch(PDO::FETCH_ASSOC)["user_token"];
        } else {
            $token = '';
        }    
        return password_verify($uniCookieToken, $token);
    }

}