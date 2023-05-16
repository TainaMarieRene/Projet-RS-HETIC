<?php

function db()
{
    $host = "localhost";
    $user = "root";
    $password = "";
    $db_name = "unilink";

    $dsn = "mysql:host=$host;dbname=$db_name";

    return new PDO($dsn, "$user", "$password", array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8mb4'));
}

function getUserPoser(int $userId)
{

    $pdo = db();
    $requete = $pdo->prepare("SELECT
    p.post_id,
    p.post_content,
    pc.post_comment_id,
    pc.post_comment_content,
    pcc.post_comment_id AS child_comment_id,
    pcc.post_comment_content AS child_comment_content,
    r.reaction_type,
    r.reaction_type_id,
    r.user_id,
    r.reaction_emoji
FROM
    friends AS f
    INNER JOIN posts AS p ON (f.user_id2 = p.user_id)
    LEFT JOIN posts_comments AS pc ON (p.post_id = pc.post_id)
    LEFT JOIN posts_comments AS pcc ON (pc.post_comment_id = pcc.post_comment_parent_id)
    LEFT JOIN reactions AS r ON (p.post_id = r.reaction_type_id AND r.reaction_type = 'post' AND r.user_id = 1)
WHERE
    f.user_id1 = 1
ORDER BY
    p.post_id, pc.post_comment_id, pcc.post_comment_id;

");
    $requete->execute([
        ':user_id' => $userId
    ]);

    $posts = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}