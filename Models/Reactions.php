<?php

namespace Reactions;

require_once '../Models/Database.php';
use Database\Database;
use PDO;
use PDOException;

class Reaction{
    private Database $_db;

    public function __construct(){
        $this->_db = new Database;
    }

    public function managReaction($reaction_type, $reaction_type_id, $user_id, $reaction_emoji){
        if(!$this->checkReaction($reaction_type, $reaction_type_id, $user_id)){
            $this->addReaction($reaction_type, $reaction_type_id, $user_id, $reaction_emoji);
        } elseif($this->checkReaction($reaction_type, $reaction_type_id, $user_id) == $reaction_emoji) {
            $this->removeReaction($reaction_type, $reaction_type_id, $user_id);
        } elseif($this->checkReaction($reaction_type, $reaction_type_id, $user_id)) {
            $this->removeReaction($reaction_type, $reaction_type_id, $user_id);
            $this->addReaction($reaction_type, $reaction_type_id, $user_id, $reaction_emoji);
        }
    }

    private function addReaction($reaction_type, $reaction_type_id, $user_id, $reaction_emoji){
        $stmt = $this->_db->_pdo->prepare("INSERT INTO reactions (reaction_type, reaction_type_id, user_id, reaction_emoji) VALUES (:reaction_type, :reaction_type_id, :user_id, :reaction_emoji)");
        $stmt->execute([
            ":reaction_type" => $reaction_type,
            ":reaction_type_id" => $reaction_type_id,
            ":user_id" => $user_id,
            ":reaction_emoji" => $reaction_emoji
        ]);
    }

    private function removeReaction($reaction_type, $reaction_type_id, $user_id){
        $stmt = $this->_db->_pdo->prepare("DELETE FROM reactions WHERE reaction_type = :reaction_type and reaction_type_id = :reaction_type_id and user_id = :user_id");
        $stmt->execute([
            ":reaction_type" => $reaction_type,
            ":reaction_type_id" => $reaction_type_id,
            ":user_id" => $user_id
        ]);
    }

    private function checkReaction($reaction_type, $reaction_type_id, $user_id){
        $stmt = $this->_db->_pdo->prepare("SELECT reaction_emoji FROM reactions WHERE reaction_type = :reaction_type and reaction_type_id = :reaction_type_id and user_id = :user_id");
        $stmt->execute([
            ":reaction_type" => $reaction_type,
            ":reaction_type_id" => $reaction_type_id,
            ":user_id" => $user_id
        ]);

        $reaction = $stmt->fetch(PDO::FETCH_ASSOC);
        return ($reaction) ? $reaction["reaction_emoji"] : false;
    }

    public function deleteAllReactions($user_id){
        $stmt = $this->_db->_pdo->prepare("DELETE FROM reactions WHERE user_id = :user_id");
        $stmt->execute([
            ":user_id" => $user_id
        ]);
    }
}