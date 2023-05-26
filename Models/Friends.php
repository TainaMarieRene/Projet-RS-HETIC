<?php

namespace Friends;

require_once '../Models/Database.php';
use Database\Database;
use PDO;
use PDOException;

class Friend {
    private Database $_db;

    public function __construct(){
        $this->_db = new Database;
    }

    public function get_friend($user_id1, $user_relation) {
        $stmt = $this->_db->_pdo->prepare("SELECT u.user_username, u.user_firstname, u.user_lastname, u.user_id, f.user_relation
        FROM friends f
        JOIN users u ON (f.user_id2 = u.user_id AND f.user_id1 = :user_id1)
                     OR (f.user_id1 = u.user_id AND f.user_id2 = :user_id1)
        WHERE f.user_relation = :user_relation;");
        $stmt->execute([
            ":user_id1"=>$user_id1,
            ":user_relation"=>$user_relation
        ]);
        return $friends = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_blocked($user_id1) {
        $stmt = $this->_db->_pdo->prepare("SELECT u.*
        FROM friends f
        JOIN users u ON u.user_id = f.user_id2
        WHERE (f.user_id1 = :user_id AND f.user_relation = 'blocked1');");
        $stmt->execute([
            ":user_id"=>$user_id1
        ]);
        return $blocked = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_blocked_by($user_id1) {
        $stmt = $this->_db->_pdo->prepare("SELECT u.user_username, u.user_firstname, u.user_lastname, u.user_id, f.user_relation
        FROM friends f
        JOIN users u ON (f.user_id2 = u.user_id AND f.user_id1 = :user_id1)
        WHERE f.user_relation = :user_relation;");
        $stmt->execute([
            ":user_id"=>$user_id1
        ]);
        return $blocked_by = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_friend_request($user_id1) {
        $stmt = $this->_db->_pdo->prepare("SELECT u.user_username, u.user_firstname, u.user_lastname, u.user_id, f.user_relation
        FROM friends f
        JOIN users u ON (f.user_id2 = u.user_id AND f.user_id1 = :user_id1)
        WHERE f.user_relation = 'waiting';");
        $stmt->execute([
            ":user_id1"=>$user_id1,
            ":user_relation"=>"waiting"
        ]);
        return $friend_request = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function get_friend_requesting($user_id1) {
        $stmt = $this->_db->_pdo->prepare("SELECT u.user_username, u.user_firstname, u.user_lastname, u.user_id, f.user_relation
        FROM friends f
        JOIN users u ON (f.user_id1 = u.user_id AND f.user_id2 = :user_id1)
        WHERE f.user_relation = 'waiting';");
        $stmt->execute([
            ":user_id1"=>$user_id1,
            ":user_relation"=>"waiting"
        ]);
        return $friend_requesting = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add_friends($user_id1, $token, $user_id2) {
        if ($this->check_token_user_id($user_id1, $token) === true) {
            if ($user_id1 === $user_id2) {
                die('Vous ne pouvez pas vous ajouter vous-même');
            }else if ($this->is_relation_exist($user_id1, $user_id2) === true) {
                die('Vous êtes déjà amis');
            } else if ($token != $_COOKIE['token']) {
                die('Erreur de token');
            } else {
                $stmt = $this->_db->_pdo->prepare("INSERT INTO friends (user_id1, user_id2, user_relation) VALUES (:user_id1, :user_id2, :user_relation)");
                $stmt->execute([
                    ":user_id1"=>$user_id1,
                    ":user_id2"=>$user_id2,
                    ":user_relation"=>"waiting"
                ]);
                // HEADER LOCATION
            }
        } else {
            die('Vous ne pouvez pas faire ça !');
        }
    }

    public function is_relation_exist($user_id1, $user_id2) {
        $stmt = $this->_db->_pdo->prepare("SELECT user_relation FROM friends
        WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2)
        OR (user_id1 = :user_id2 AND user_id2 = :user_id1)");
        $stmt->execute([
            ":user_id1"=>$user_id1,
            ":user_id2"=>$user_id2
        ]);
        $relation = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($relation) { // A VERIFIER Je suis pas sur que ça marche comment ça 
            return true;
        } else {
            return false;
        }
    }

    public function delete_friend($user_id1, $token, $user_id2) {
        if ($this->check_token_user_id($user_id1, $token) === true) {
            $stmt = $this->_db->_pdo->prepare("DELETE FROM friends WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2) OR (user_id1 = :user_id2 AND user_id2 = :user_id1)");
            $stmt->execute([
                ":user_id1"=>$user_id1,
                ":user_id2"=>$user_id2
            ]);
            // HEADER LOCATION
        } else {
            die('Vous ne pouvez pas faire ça !');
        }
    }

    public function accept_friend($user_id1, $token, $user_id2) {
        if ($this->check_token_user_id($user_id1, $token) === true) {
            $stmt = $this->_db->_pdo->prepare("UPDATE friends SET user_relation = 'friend' WHERE user_id1 = :user_id1 AND user_id2 = :user_id2");
            $stmt->execute([
                ":user_id1"=>$user_id1,
                ":user_id2"=>$user_id2
            ]);
            // HEADER LOCATION
        } else {
            die('Vous ne pouvez pas faire ça !');
        }
    }

    public function block_friend($user_id1, $token, $user_id2) {
        if ($this->check_token_user_id($user_id1, $token) === true) {
            $stmt = $this->_db->_pdo->prepare("UPDATE friends
            SET user_relation = 
                CASE
                    WHEN (user_id1 = :user_id AND user_id2 = :user_id2) THEN 'blocked1'
                    WHEN (user_id1 = :user_id2 AND user_id2 = :user_id) THEN 'blocked2'
                END
            WHERE (user_id1 = :user_id AND user_id2 = :user_id2 AND (user_relation = 'friend' OR user_relation = 'waiting'))
               OR (user_id1 = :user_id2 AND user_id2 = :user_id AND (user_relation = 'friend' OR user_relation = 'waiting'));");
            $stmt->execute([
                ":user_id1"=>$user_id1,
                ":user_id2"=>$user_id2
            ]);
            // HEADER LOCATION
        } else {
            die('Vous ne pouvez pas faire ça !');
        }
    }

    public function unblock_friend($user_id1, $user_id2, $token) {
        if ($this->check_token_user_id($user_id1, $token) === true) {
            if ($this->can_unblock($user_id1, $user_id2) === false) {
                die('Vous ne pouvez pas débloquer cette personne');
            } else {
                $stmt = $this->_db->_pdo->prepare("DELETE FROM friends
                WHERE (user_id1 = :user_id AND user_id2 = :user_id2)
                   OR (user_id1 = :user_id2 AND user_id2 = :user_id);");
                $stmt->execute([
                    ":user_id1"=>$user_id1,
                    ":user_id2"=>$user_id2
                ]);
                // HEADER LOCATION
            }
        } else {
            die('Vous ne pouvez pas faire ça !');
        }
    }

    public function can_unblock($user_id1, $user_id2) {
        $stmt = $this->_db->_pdo->prepare("SELECT user_relation
        FROM friends
        WHERE user_id1 = :user_id1 AND user_id2 = :user_id2;");
        $stmt->execute([
            ":user_id1"=>$user_id1,
            ":user_id2"=>$user_id2
        ]);
        $relation = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($relation && isset($result['user_relation']) && $relation['user_relation'] === 'blocked1') {
            return false;
        } else {
            return true;
        }
    }
}