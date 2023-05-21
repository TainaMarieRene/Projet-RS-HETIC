<?php
namespace Feed;

use Database\Database;
use DateTime;
use Exception;
use PDOException;

class FeedController extends Database {
    private int $userId;
    public function __construct(){
        parent::__construct();
        $this->setUserId(1);
    }

    public function setUserId(int $userCookieId): void {
        $this->userId = $userCookieId;
//        En tant normal, aller chercher la data dans les cookies
    }

    public function getUserName(): string {
        try {
            $query = $this->_pdo->prepare("SELECT user_username FROM users WHERE user_id = :userId");
            $query->execute([
                ":userId" => $this->userId
            ]);
            return $query->fetch()["user_username"];
        } catch (PDOException $e) {
            return $e;
        }
}

    public function getFeedPosts(): array
    {
        try {
            $friendsPostsQuery = $this->_pdo->prepare("
        SELECT
            CONCAT(u.user_firstname, ' ', u.user_lastname) AS `Friends PP`,
            u.user_username AS `author`,
            pst.post_id AS `id`,
            pst.post_content AS `content`,
            pst.post_date AS `date`,
            COUNT(rct.user_id) AS `likesCount`,
            COUNT(cmt.post_comment_id) AS `commentsCount`
        FROM
            friends f
            INNER JOIN users u ON (f.user_id1 = u.user_id OR f.user_id2 = u.user_id)
            INNER JOIN posts pst ON (pst.user_id = u.user_id AND pst.post_type = 'profile')
            LEFT JOIN reactions rct ON (rct.reaction_type = 'profil' AND rct.reaction_type_id = pst.post_id AND rct.user_id = :userId)
            LEFT JOIN posts_comments cmt ON (cmt.post_id = pst.post_id)
        WHERE
            (f.user_id1 = :userId OR f.user_id2 = :userId) AND f.user_relation = 'friend'
        GROUP BY
            u.user_firstname, u.user_lastname, u.user_username, pst.post_id, pst.post_content
        ");

            $pagesPostsQuery = $this->_pdo->prepare("
        SELECT
          pg.page_at AS 'author',
          pst.post_id AS 'id',
          pst.post_content AS 'content',
          pst.post_date AS 'date',
          COUNT(rct.user_id) AS 'likesCount',
          COUNT(cmt.post_comment_id) AS 'commentsCount'
        FROM
          members m
          INNER JOIN pages pg ON m.member_type_id = pg.page_id
          LEFT JOIN posts pst ON (pst.post_type = 'page' AND pst.post_type_id = pg.page_id)
          LEFT JOIN reactions rct ON (rct.reaction_type = 'page' AND rct.reaction_type_id = pg.page_id AND rct.user_id = 1)
          LEFT JOIN posts_comments cmt ON (cmt.post_id = pst.post_id)
        WHERE
          m.user_id = :userId
        GROUP BY
        pg.page_name, pg.page_at, pst.post_id, pst.post_content");

            $friendsPostsQuery->execute([
                ":userId" => $this->userId
            ]);

            $pagesPostsQuery->execute([
                ":userId" => $this->userId
            ]);

            $friendsPostsArray = $friendsPostsQuery->fetchAll();
            $pagesPostsArray = $pagesPostsQuery->fetchAll();

            return array_merge($friendsPostsArray, $pagesPostsArray);
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function getDateDiff(string $postDate): string {
        try {
            $postDateTime = new DateTime($postDate);
            $currentDateTime = new DateTime();

            $interval = $postDateTime->diff($currentDateTime);

            return match (true) {
                $interval->y > 0 => $postDateTime->format('M d, Y'),
                $interval->m > 0 => $interval->m . 'm ago',
                $interval->d > 0 => $interval->d . 'd ago',
                $interval->h > 0 => $interval->h . 'h ago',
                $interval->i > 0 => $interval->i . 'm ago',
                default => 'Just now',
            };
        } catch (Exception $e) {
            return ($e);
        }
    }

    public function createUserPost(string $postContent) {
        try {
            $postQuery = $this->_pdo->prepare("
            INSERT INTO 
                `posts` (`post_id`, `user_id`, `post_type`, `post_type_id`, `post_date`, `post_content`) 
            VALUES (NULL, :userId, 'profile', '0', current_timestamp(), :postContent)
        ");

            $postQuery->execute([
                ":userId" => $this->userId,
                ":postContent" => $postContent
            ]);

            $postQuery->fetchAll();

            return "Successfully posted";
        } catch (PDOException $e) {
            return $e;
        }
    }

    public function postImage(){
        $target_dir = "assets/imgs/users/posts/";
        $target_file = $target_dir . uniqid() . '' . basename($_FILES["postImg"]["name"]);
        $fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $allowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'pdf');
        if (in_array($fileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES["postImg"]["tmp_name"], $target_file)) {
                var_dump(htmlspecialchars( basename( $_FILES["postImg"]["name"])));
            } else {
                var_dump("error");
            }
        } else {
            var_dump("badFile");
        }
    }
}

