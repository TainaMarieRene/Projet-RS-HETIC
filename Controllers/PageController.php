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

        $pageCreateResult = $pageCreateQuery->fetch();
        var_dump($pageCreateResult);
}
}