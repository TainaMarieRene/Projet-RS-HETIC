<?php

namespace Post;
use Database\Database;
use PDOException;
class PostPageController extends Database
{
    public int $postId;
    public string $postType;
    public function __construct()
    {
        parent::__construct();
        $this->setPostId();
    }


    public function setPostId(): void
    {
        $this->postId = $_GET["id"] ?? 0;
        $this->postType = $_GET["type"] ?? "";
    }

    public function renderData(): array|string
    {
        if (!$this->postId) {
            return [
                "code" => 404,
                "message" => "Invalid ID"
            ];
        }

        if (!$this->postType) {
            return [
                "code" => 404,
                "message" => "Invalid type"
            ];
        }

        try {
            switch($this->postType) {
                case "profile":
                    $postDataQuery = $this->_pdo->prepare("
                         SELECT u.user_username as author,
                               p.post_date as date,
                               p.post_content as content,
                                u.user_id as author_id
                        FROM posts AS p
                        JOIN users AS u ON u.user_id = p.user_id
                        WHERE p.post_id = :postId AND p.post_type = :postType;
                    ");
                    break;
                case "page":
                    $postDataQuery = $this->_pdo->prepare("
                         SELECT pa.page_at as author,
                               p.post_date as date,
                               p.post_content as content,
                               pa.page_id as author_id
                        FROM posts AS p
                        JOIN pages AS pa ON pa.page_id = p.post_type_id
                        WHERE p.post_id = :postId AND p.post_type = :postType;
                    ");
                    break;
                default:
                    $postDataQuery = false;
                    break;
            }

            $postDataQuery->execute([
                ":postId" => $this->postId,
                ":postType" => $this->postType
            ]);

            $postData = $postDataQuery->fetch();

            if (!$postData) {
                return [
                    "status" => "error",
                    "code" => 404,
                    "message" => "This post doesn't not exist"
                ];
            }

            $commentDataQuery = $this->_pdo->prepare("
                SELECT pc.post_comment_date as date,
                        pc.post_comment_content as content,
                        u.user_username as author,
                        u.user_id as author_id
                FROM posts_comments AS pc
                JOIN users AS u ON u.user_id = pc.user_id
                WHERE post_id = :postId
                ORDER BY pc.post_comment_date ASC;
            ");

            $commentDataQuery->execute([
                ":postId" => $this->postId
            ]);

            $commentData = $commentDataQuery->fetchAll();

            return [
                "status" => "success",
                "postData" => $postData,
                "commentsData" => $commentData
            ];
        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
    }

}