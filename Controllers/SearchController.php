<?php

namespace Search;

use Database\Database;

class SearchController extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public function search(string $inputString): void
    {
        $url = "Location: http://localhost/projet-rs-hetic/public/index.php?p=search&filter=".$inputString;
        header($url);
    }

    public function getAccounts(string $filter): array
    {
        $filterUsersQuery = $this->_pdo->prepare("
            SELECT u.user_username AS at, 
                   CONCAT_WS(' ',u.user_firstname, u.user_lastname) AS name,
                   u.user_account_status AS status, 
                   u.user_id AS id
            FROM users u
            WHERE u.user_username LIKE CONCAT('%',:filter, '%')
              OR u.user_firstname LIKE CONCAT('%',:filter, '%')
              OR u.user_lastname LIKE CONCAT('%',:filter, '%')
              AND u.user_account_status = 'valid'
              AND u.user_account_status <> 'disable'
            ;
        ");
        $filterPagesQuery = $this->_pdo->prepare("
            SELECT p.page_at AS at, 
                   p.page_creator AS author, 
                   p.page_name AS name,
                   p.page_id AS id
            FROM pages p
            WHERE p.page_at LIKE CONCAT('%',:filter, '%');
        ");

        $filterUsersQuery->execute([
            ":filter" => $filter
        ]);
        $filterPagesQuery->execute([
            ":filter" => $filter
        ]);

        return [
          "users" => $filterUsersQuery->fetchAll(),
          "pages" => $filterPagesQuery->fetchAll()
        ];
    }
}