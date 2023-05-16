<?php

function db() {
    $host = "localhost";
    $user = "root";
    $password = "";
    $db_name = "unilink";

    $dsn = "mysql:host=$host;dbname=$db_name";

    return new PDO($dsn,"$user","$password",array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
}

function getUserPoser(int $userId) {

    $pdo = db();
    $requete = $pdo->prepare("SELECT p.post_id, p.post_content, p.post_date
FROM posts p
JOIN friends f ON (f.user_id1 = p.user_id OR f.user_id2 = p.user_id)
WHERE (f.user_id1 = :user_id OR f.user_id2 = :user_id)
AND p.post_type = 'profile'
ORDER BY p.post_date DESC;");
    $requete->execute([
        ':user_id' => $userId
    ]);

    $posts = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}