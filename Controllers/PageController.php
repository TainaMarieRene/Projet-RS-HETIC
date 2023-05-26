<?php

namespace Page;

class PageController extends \Database\Database
{

    public function __construct()
    {
        parent::__construct();
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

    public function getData(): array
    {
        $myPagesQuery = $this->_pdo->prepare("
            SELECT p.page_at AS at, 
                   p.page_creator AS author, 
                   p.page_name AS name,
                   p.page_id AS id,
                   p.page_desc AS bio
            FROM pages AS p
            WHERE p.page_creator = :userId;
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
            WHERE p.page_creator = :userId AND mpe.member_page_role = 'follower';
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
}