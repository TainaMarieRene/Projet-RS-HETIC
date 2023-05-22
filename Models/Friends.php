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

    public function addFriend($user_id1, $user_id2):void {
        $stmt = $this->_db->_pdo->prepare("INSERT INTO friends (user_id1, user_id2, user_relation)
        VALUES (:user_id1, :user_id2, 'waiting')");
        $stmt->execute([
            ":user_id1" => $user_id1,
            ":user_id2" => $user_id2
        ]);
        $stmt->closeCursor();
    }

    public function acceptRelation($user_id1, $user_id2):void {
        $stmt = $this->_db->_pdo->prepare("UPDATE friends
        SET user_relation = 'friend'
        WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2)
        OR (user_id1 = :user_id2 AND user_id2 = :user_id1)
        AND user_relation = 'waiting'");
        $stmt->execute([
            ":user_id1" => $user_id1,
            ":user_id2" => $user_id2
        ]);
        $stmt->closeCursor();
    }

    public function deleteFriend($user_id1, $user_id2):void {
        $stmt = $this->_db->_pdo->prepare("DELETE FROM friends WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2) OR (user_id1 = :user_id2 AND user_id2 = :user_id1)");
        $stmt->execute([
            ":user_id1" => $user_id1,
            ":user_id2" => $user_id2
        ]);
        $stmt->closeCursor();
    }

    public function blockFriend($user_id1, $user_id2):void {
        $stmt = $this->_db->_pdo->prepare("UPDATE friends 
        SET user_relation = 'blocked'
        WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2 AND (user_relation = 'friend' OR user_relation = 'waiting'))
           OR (user_id1 = :user_id2 AND user_id2 = :user_id1 AND (user_relation = 'friend' OR user_relation = 'waiting'));
        
        INSERT INTO friends (user_id1, user_id2, user_relation)
        SELECT :user_id1, :user_id2, 'blocked'
        WHERE NOT EXISTS (
            SELECT 1
            FROM friends
            WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2)
               OR (user_id1 = :user_id2 AND user_id2 = :user_id1)");
        $stmt->execute([
            ":user_id1" => $user_id1,
            ":user_id2" => $user_id2
        ]);
        $stmt->closeCursor();
    }

    public function unblockFriend($user_id1, $user_id2) {
        $stmt = $this->_db->_pdo->prepare("DELETE FROM friends WHERE (user_id1 = :user_id1 AND user_id2 = :user_id2) OR (user_id1 = :user_id2 AND user_id2 = :user_id1);
        ");
        $stmt->execute([
                ":user_id1" => $user_id1,
                ":user_id2" => $user_id2
        ]);
        $stmt->closeCursor();
    }
}