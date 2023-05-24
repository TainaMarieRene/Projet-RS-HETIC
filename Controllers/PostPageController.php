<?php

namespace Post;

use Database\Database;
use Exception;
use PDOException;
class PostPageController extends Database
{
    private int $postId;
    public function __construct()
    {
        parent::__construct();
        $this->setPostId();
    }


    public function setPostId(): void
    {
        $this->postId = $_GET["id"] ?? 0;
    }

    public function renderData(): array|string
    {
        if (!$this->postId) {
            return [
                "code" => 404,
                "message" => "Invalid ID"
            ];
        }

        try {
            $postDataQuery = $this->_pdo->prepare("
                 SELECT u.user_username as author,
                       p.post_date as date,
                       p.post_content as content
                FROM posts AS p
                JOIN users AS u ON u.user_id = p.user_id
                WHERE p.post_id = :postId;
                    ");

            $postDataQuery->execute([
                ":postId" => $this->postId
            ]);

            $postData = $postDataQuery->fetch();

            if (!$postData) {
                return [
                    "code" => 404,
                    "message" => "Invalid ID"
                ];
            }

            $commentDataQuery = $this->_pdo->prepare("
                SELECT pc.post_comment_date as date,
                        pc.post_comment_content as content,
                        U.user_username as author
                FROM posts_comments AS pc
                JOIN users AS u ON u.user_id = pc.user_id
                WHERE post_id = :postId;
            ");

            $commentDataQuery->execute([
                ":postId" => $this->postId
            ]);

            $commentData = $commentDataQuery->fetchAll();


            return [
                "postData" => $postData,
                "commentsData" => $commentData
            ];
        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
    }
}