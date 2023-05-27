<?php

namespace Page;

use Exception;

class PageController extends \Database\Database
{
    private int $pageId;
    public function __construct()
    {
        parent::__construct();
        $this->pageId = $_GET["page_id"] ?? 0;
    }

    public function createPage(string $at, string $name, string $bio, string $niche) {
        $pageCreateQuery = $this->_pdo->prepare("
            INSERT INTO `pages`(`page_creator`, `page_at`, `page_name`, `page_desc`, `page_tag`) 
            VALUES (:userId,:pageAt,:pageName,:pageBio,:pageNiche);
        ");

        $pageCreateQuery->execute([
            ":userId" => $_COOKIE['uniCookieUserID'],
            ":pageAt" => $at,
            ":pageName" => $name,
            ":pageBio" => $bio,
            ":pageNiche" => $niche
        ]);


        $getPageId = $this->_pdo->lastInsertId();

        $createMember = $this->_pdo->prepare("
            INSERT INTO `members` (`member_type`, `member_type_id`, `user_id`) 
            VALUES ('page', :pageId, :userId); 
        ");

        $createMember->execute([
            ":userId" => $_COOKIE['uniCookieUserID'],
            ":pageId" => $getPageId
        ]);

        $this->createAdmin($this->_pdo->lastInsertId());
    }

    public function createAdmin(int $memberId) {
        $createAdmin = $this->_pdo->prepare("
                INSERT INTO `members_pages_extra` (member_id, member_page_role) 
                VALUES (:memberId, 'admin'); 
            ");
        $createAdmin->execute([
            ":memberId" => $memberId
        ]);
    }

    public function getAllPagesData(): array
    {
        $myPagesQuery = $this->_pdo->prepare("
            SELECT p.page_at AS at, 
                   p.page_creator AS author, 
                   p.page_name AS name,
                   p.page_id AS id,
                   p.page_desc AS bio
            FROM pages AS p
            JOIN members AS m ON m.member_type_id = p.page_id
            JOIN members_pages_extra mpe on m.member_id = mpe.member_id
            WHERE m.user_id = :userId AND mpe.member_page_role='admin';
        ");

        $followedPagesQuery = $this->_pdo->prepare("
            SELECT p.page_at AS at, 
                   p.page_creator AS author, 
                   p.page_name AS name,
                   p.page_id AS id,
                   p.page_desc AS bio
            FROM pages AS p
            JOIN members AS m ON m.member_type_id = p.page_id
            JOIN members_pages_extra mpe on m.member_id = mpe.member_id
            WHERE m.user_id = :userId AND mpe.member_page_role = 'follower';
        ");

        $followedPagesQuery->execute([
            ":userId" => $_COOKIE['uniCookieUserID']
        ]);

        $myPagesQuery->execute([
            ":userId" => $_COOKIE['uniCookieUserID']
        ]);

        return [
            "myPages" => $myPagesQuery->fetchAll(),
            "followed" => $followedPagesQuery->fetchAll()
        ];
    }
    public function getSinglePageData(): array
    {
        $pageInfoQuery = $this->_pdo->prepare("
            SELECT p.page_at AS at, 
                   p.page_id AS id,
                   p.page_name AS name,
                   COUNT(m.member_id) AS followersCount,
                   p.page_desc AS bio
           FROM pages AS p
           JOIN members m ON m.member_type_id = p.page_id
            WHERE p.page_id = :pageId;
        ");

        $pageAdminQuery = $this ->_pdo->prepare("
        SELECT u.user_username AS admin_name, 
            u.user_id AS admin_id
        FROM users u
        JOIN pages p on u.user_id = p.page_creator
        JOIN members m on m.member_type_id = p.page_id
        JOIN members_pages_extra mpe on m.member_id = mpe.member_id
        WHERE mpe.member_page_role = 'admin' AND p.page_id = :pageId;
        ");

        $pagePostsQuery = $this->_pdo->prepare("
            SELECT 
              pst.post_id AS 'id',
            pst.post_type_id AS `author_id`,
              pst.post_type AS 'type',
              pst.post_content AS 'content',
              pst.post_date AS 'date',
              COUNT(rct.user_id) AS 'likesCount',
              COUNT(cmt.post_comment_id) AS 'commentsCount'
            FROM
              pages AS pg
              LEFT JOIN posts pst ON (pst.post_type = 'page' AND pst.post_type_id = pg.page_id)
              LEFT JOIN reactions rct ON (rct.reaction_type = 'page' AND rct.reaction_type_id = pg.page_id)
              LEFT JOIN posts_comments cmt ON (cmt.post_id = pst.post_id)
            WHERE
              pg.page_id = :pageId
            GROUP BY
            pg.page_name, pg.page_at, pst.post_id, pst.post_content, pst.post_date
            ORDER BY pst.post_date DESC ; 
        ");

        $pageAdminQuery->execute([
            ":pageId" => $this->pageId
        ]);
        $pageInfoQuery->execute([
            ":pageId" => $this->pageId
        ]);
        $pagePostsQuery->execute([
           ":pageId" => $this->pageId
        ]);

        return [
            "admins" => $pageAdminQuery->fetchAll(),
            "info" => $pageInfoQuery->fetch(),
            "posts" => $pagePostsQuery->fetchAll(),
        ];
    }

    public  function isAdmin(): bool
    {
        if (!$this->isFollower()) {
            return false;
        }
        $memberId = ($this->isFollower())["member_id"];
        $checkAdminQuery = $this->_pdo->prepare("
           SELECT * 
           FROM members_pages_extra AS mpe 
           JOIN members m on m.member_id = mpe.member_id
           WHERE mpe.member_page_role='admin' AND mpe.member_id = :memberId
        ");

        $checkAdminQuery->execute([
            "memberId" => $memberId
        ]);

        return (bool)$checkAdminQuery->fetchAll();
    }
    public function isFollower() {
        $checkFollowerQuery = $this->_pdo->prepare("
        SELECT m.member_id FROM users u 
        JOIN members m on u.user_id = m.user_id
        WHERE u.user_id = :userId AND m.member_type_id = :pageId;
        ");

        $checkFollowerQuery->execute([
            ":userId" => $_COOKIE["uniCookieUserID"],
            ":pageId" => $this->pageId
        ]);

        return $checkFollowerQuery->fetch();
    }

    public function setAsFollower(int $memberId): void
    {
        $setFollowerQuery = $this->_pdo->prepare("
            INSERT INTO members_pages_extra (member_id, member_page_role) 
            VALUES (:memberId, 'follower');
        ");

        $setFollowerQuery->execute([
            ":memberId" => $memberId
        ]);
    }

    public function setAsAdmin(int $memberId) {
        $setAdminQuery = $this->_pdo->prepare("
        INSERT INTO members_pages_extra (member_id, member_page_role) 
            VALUES (:memberId, 'admin');
        ");

        $setAdminQuery->execute([
            ":memberId" => $memberId
        ]);
    }

    public function follow(): void
    {
        $followQuery = $this->_pdo->prepare("
            INSERT INTO members ( member_id,`member_type`, `member_type_id`, `user_id`) 
            VALUES (NULL ,'page',:pageId,:userId);
        ");
        $followQuery->execute([
            ":pageId" => $this->pageId,
            "userId" => $_COOKIE["uniCookieUserID"]
        ]);

        $memberId = $this->_pdo->lastInsertId();
        $this->setAsFollower($memberId);
    }

    public function unfollow() {
        $memberId = ($this->isFollower())["member_id"];
        $unfollowQueryExtra = $this->_pdo->prepare("
            DELETE FROM members_pages_extra WHERE member_id = :memberId;
        ");
        $unfollowQuery = $this->_pdo->prepare(
            "DELETE FROM members WHERE member_id = :memberId;"
        );


        $unfollowQueryExtra->execute([
            ":memberId" => $memberId
        ]);
        $unfollowQuery->execute([
            ":memberId" => $memberId
        ]);
    }

    public function createPagePost(string $postContent) {
        try {
            $postQuery = $this->_pdo->prepare("
                            INSERT INTO 
                    `posts` (`post_id`, `user_id`, `post_type`, `post_type_id`, `post_date`, `post_content`) 
                VALUES (NULL, :userId, 'page', :pageId, current_timestamp(), :postContent)
            ");

            $postQuery->execute([
                ":userId" => $_COOKIE["uniCookieUserID"],
                ":postContent" => $postContent,
                ":pageId" => $this->pageId
            ]);

            $postQuery->fetchAll();

            return "Successfully posted";
        } catch (Exception $e) {
            return $e;
        }
    }

    public function deletePost(int $postId) {
        $deletePostQuery = $this->_pdo->prepare("
            DELETE FROM posts WHERE post_id = :postId;
        ");

        $deletePostQuery->execute([
           ":postId" => $postId
        ]);
    }

}