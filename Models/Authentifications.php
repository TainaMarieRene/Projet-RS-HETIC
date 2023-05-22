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
        // Check if a token already exist (if user clear cookies)
        $isValidToken = $this->getToken($user["user_username"], $_SERVER['HTTP_USER_AGENT'], $user["user_id"]);
        if($isValidToken){
            $this->deleteToken($user["user_username"], $_SERVER['HTTP_USER_AGENT'], $user["user_id"]);
        }

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

    public function deleteToken($user_username, $user_agent, $user_id){
        $stmt = $this->_db->_pdo->prepare("DELETE FROM authentifications WHERE user_username = :user_username AND user_agent = :user_agent AND user_id = :user_id");
        $stmt->execute([
            ":user_username" => $user_username,
            ":user_agent" => $user_agent,
            ":user_id" => $user_id
        ]);
    }

    public function deleteAllToken($user_username, $user_id){
        $stmt = $this->_db->_pdo->prepare("DELETE FROM authentifications WHERE user_username = :user_username AND user_id = :user_id");
        $stmt->execute([
            ":user_username" => $user_username,
            ":user_id" => $user_id
        ]);
    }

    public function getToken($uniCookieUsername, $uniCookieAgent, $uniCookieUserID){
        $stmt = $this->_db->_pdo->prepare("SELECT * FROM authentifications WHERE user_username = :user_username AND user_agent = :user_agent AND user_id = :user_id");
        $stmt->execute([
            ":user_username" => $uniCookieUsername,
            ":user_agent" => $uniCookieAgent,
            ":user_id" => $uniCookieUserID
        ]);

        $token = $stmt->fetch(PDO::FETCH_ASSOC);

        return $token;
    }

    public function validToken($uniCookieUsername, $uniCookieAgent, $uniCookieToken, $uniCookieUserID){
        $isValidToken = $this->getToken($uniCookieUsername, $uniCookieAgent, $uniCookieUserID);

        if($isValidToken && date("Y-m-d G:i:s", time()) > $isValidToken["user_token_end"]){
            $stmt = $this->_db->_pdo->prepare("DELETE FROM authentifications WHERE user_username = :user_username AND user_agent = :user_agent AND user_id = :user_id");
            $stmt->execute([
                ":user_username" => $uniCookieUsername,
                ":user_agent" => $uniCookieAgent,
                ":user_id" => $uniCookieUserID
            ]);
            setcookie('uniCookieUserID', '', time()-(3600));
            setcookie('uniCookieUsername', '', time()-3600);
            setcookie('uniCookieAgent', '', time()-3600);
            setcookie('uniCookieToken', '', time()-3600);
        }

        return (date("Y-m-d G:i:s", time()) < $isValidToken);
    }

    public function areLogin($uniCookieUsername, $uniCookieAgent, $uniCookieToken, $uniCookieUserID){
        $token = '';
        if($uniCookieUsername && $uniCookieAgent && $uniCookieToken && $uniCookieUserID && $this->validToken($uniCookieUsername, $uniCookieAgent, $uniCookieToken, $uniCookieUserID)){
            $stmt = $this->_db->_pdo->prepare("SELECT user_token FROM authentifications WHERE user_username = :user_username AND user_agent = :user_agent AND user_id = :user_id");
            $stmt->execute([
                ":user_username" => $uniCookieUsername,
                ":user_agent" => $uniCookieAgent,
                ":user_id" => $uniCookieUserID
            ]);
            $token = $stmt->fetch(PDO::FETCH_ASSOC)["user_token"];
        } else {
            setcookie('uniCookieUserID', '', time()-(3600));
            setcookie('uniCookieUsername', '', time()-3600);
            setcookie('uniCookieAgent', '', time()-3600);
            setcookie('uniCookieToken', '', time()-3600);
        }

        return password_verify($uniCookieToken, $token);
    }

}