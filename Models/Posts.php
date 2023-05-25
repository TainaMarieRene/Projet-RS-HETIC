<?php

namespace Posts;

require_once '../Models/Database.php';
use Database\Database;
use PDO;
use PDOException;

class Post{
    private Database $_db;

    public function __construct(){
        $this->_db = new Database;
    }

    public function createPost($user_id, $post_type, $post_type_id, $post_content, $post_img = '') {
        $stmt = $this->_db->_pdo->prepare("INSERT INTO posts (user_id, post_type, post_type_id, post_content) VALUES (:user_id, :post_type, :post_type_id, :post_content)");
        $stmt->execute([
            ":user_id" => $user_id,
            ":post_type" => $post_type,
            ":post_type_id" => $post_type_id,
            ":post_content" => $post_content,
        ]);

        if($post_img){
            $stmt = $this->_db->_pdo->prepare("INSERT INTO posts_imgs (post_id, post_img) VALUES (:post_id, :post_img)");
            $stmt->execute([
                ":post_id" => $this->_db->_pdo->lastInsertId(),
                ":post_img" => $post_img
            ]);
        }
    }

    public function getUserProfilePosts($user_id) {
        $stmt = $this->_db->_pdo->prepare("SELECT posts.*, posts_imgs.post_img FROM posts LEFT JOIN posts_imgs ON posts.post_id = posts_imgs.post_id WHERE posts.user_id = :user_id AND posts.post_type = :post_type ORDER BY posts.post_date DESC");
        $stmt->execute([
            ":user_id" => $user_id,
            ":post_type" => "profile"
        ]);
        $userProfilePosts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $userProfilePosts;
    }

    private function ifPostAsImg($post_id, $user_id){
        $stmt = $this->_db->_pdo->prepare("SELECT posts_imgs.post_img FROM posts LEFT JOIN posts_imgs ON posts.post_id = posts_imgs.post_id WHERE posts.post_id = :post_id AND posts.user_id = :user_id");
        $stmt->execute([
            ":post_id" => $post_id,
            ":user_id" => $user_id
        ]);
        $post_img = $stmt->fetch(PDO::FETCH_ASSOC)["post_img"];

        return $post_img;
    }

    public function deletePost($post_id, $user_id){

        if($this->ifPostAsImg($post_id, $user_id)){
            $stmt = $this->_db->_pdo->prepare("DELETE FROM posts_imgs WHERE post_id = :post_id");
            $stmt->execute([
                ":post_id" => $post_id,
            ]);
        }
        
        $stmt = $this->_db->_pdo->prepare("DELETE FROM posts WHERE post_id = :post_id and user_id = :user_id");
        $stmt->execute([
            ":post_id" => $post_id,
            ":user_id" => $user_id
        ]);

        return $post_img;
    }

    public function imgIsUse($post_img){
        $stmt = $this->_db->_pdo->prepare("SELECT * FROM posts_imgs WHERE post_img = :post_img");
        $stmt->execute([
            ":post_img" => $post_img,
        ]);

        return ($stmt->fetch(PDO::FETCH_ASSOC)) ? true : false;
    }

    public function deleteAllPosts($user_id){
        $stmt = $this->_db->_pdo->prepare("SELECT * FROM posts WHERE user_id = :user_id");
        $stmt->execute([
            ":user_id" => $user_id
        ]);

        $allPost = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($allPost as $post){
            $post_img = $this->ifPostAsImg($post["post_id"], $user_id);
            if($post_img){
                $stmt = $this->_db->_pdo->prepare("DELETE FROM posts_imgs WHERE post_id = :post_id");
                $stmt->execute([
                    ":post_id" => $post["post_id"]
                ]);

                if(!$this->imgIsUse($post_img)){
                    unlink("../Views/assets/imgs/users/posts/" . $post_img);
                }
            }

            $stmt = $this->_db->_pdo->prepare("DELETE FROM posts WHERE post_id = :post_id and user_id = :user_id");
            $stmt->execute([
                ":post_id" => $post["post_id"],
                ":user_id" => $user_id
            ]);
        }
    }
}