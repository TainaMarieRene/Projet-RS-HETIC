<?php

namespace Comments;

require_once '../Models/Database.php';
use Database\Database;
use PDO;
use PDOException;

class Comment{
    private Database $_db;

    public function __construct(){
        $this->_db = new Database;
    }

    public function createComment($post_id, $user_id, $commentContent, $post_comment_parent_id = ''){
        if($post_comment_parent_id){
            $stmt = $this->_db->_pdo->prepare("INSERT INTO posts_comments (post_id, user_id, post_comment_content, post_comment_parent_id) VALUES (:post_id, :user_id, :post_comment_content, :post_comment_parent_id)");
            $stmt->execute([
                ":post_id" => $post_id,
                ":user_id" => $user_id,
                ":post_comment_content" => $commentContent,
                ":post_comment_parent_id" => $post_comment_parent_id
            ]);
        } else {
            $stmt = $this->_db->_pdo->prepare("INSERT INTO posts_comments (post_id, user_id, post_comment_content) VALUES (:post_id, :user_id, :post_comment_content)");
            $stmt->execute([
                ":post_id" => $post_id,
                ":user_id" => $user_id,
                ":post_comment_content" => $commentContent
            ]);
        }
    }

    public function getCommentPosts($post_id, $post_comment_parent_id = ''){
        if($post_comment_parent_id){
            $stmt = $this->_db->_pdo->prepare("SELECT posts_comments.*, users.user_username FROM posts_comments JOIN users ON posts_comments.user_id = users.user_id WHERE post_id = :post_id and post_comment_parent_id = :post_comment_parent_id");
            $stmt->execute([
                ":post_id" => $post_id,
                ":post_comment_parent_id" => $post_comment_parent_id
            ]);
        } else {
            $stmt = $this->_db->_pdo->prepare("SELECT posts_comments.*, users.user_username FROM posts_comments JOIN users ON posts_comments.user_id = users.user_id WHERE post_id = :post_id AND post_comment_parent_id IS NULL ORDER BY posts_comments.post_comment_date DESC");
            $stmt->execute([
                ":post_id" => $post_id,
            ]);
        }

        $comments = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $comments;
    }

    public function deleteComment($post_comment_id, $user_id){
        $stmt = $this->_db->_pdo->prepare("DELETE FROM posts_comments WHERE post_comment_id = :post_comment_id and user_id = :user_id");
        $stmt->execute([
            ":post_comment_id" => $post_comment_id,
            ":user_id" => $user_id
        ]);
    }

    public function getCommentById($comment_id){
        $stmt = $this->_db->_pdo->prepare("SELECT * FROM posts_comments WHERE post_comment_id = :comment_id");
        $stmt->execute([
            ":comment_id" => $comment_id
        ]);

        $comment = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return $comment;
    }
}