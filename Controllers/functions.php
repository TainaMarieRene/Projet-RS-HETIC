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

// function getUserPosts(int $userId){
//     $pdo = db();
//     $postContent = null;
//     $requete = $pdo->prepare("SELECT
//         p.post_id,
//         p.post_content,
//         pc.post_comment_id,
//         pc.post_comment_content,
//         pcc.post_comment_id AS child_comment_id,
//         pcc.post_comment_content AS child_comment_content,
//         r.reaction_type,
//         r.reaction_type_id,
//         r.user_id,
//         r.reaction_emoji
//     FROM
//         friends AS f
//         INNER JOIN posts AS p ON f.user_id2 = p.user_id
//         LEFT JOIN posts_comments AS pc ON p.post_id = pc.post_id
//         LEFT JOIN posts_comments AS pcc ON pc.post_comment_id = pcc.post_comment_parent_id
//         LEFT JOIN reactions AS r ON p.post_id = r.reaction_type_id AND r.reaction_type = 'post' AND r.user_id = :user_id
//     WHERE
//         f.user_id1 = :user_id
//     ORDER BY
//         p.post_id, pc.post_comment_id, pcc.post_comment_id");

//     $requete->execute([
//         ':user_id' => $userId,
//         ':post_content' => $postContent
//     ]);

//     $posts = $requete->fetchAll(PDO::FETCH_ASSOC);

//     return $posts;
// }

function getUserPosts(int $userId){
    $pdo = db();

$requete = $pdo->prepare("SELECT
        CONCAT(u.user_firstname, ' ', u.user_lastname) AS `Friends PP`,
        u.user_username AS `Friends Pseudo`,
        pst.post_id AS `Friends Post`,
        pst.post_content AS `Post friend content`,
        COUNT(rct.user_id) AS `Post friend like`,
        COUNT(cmt.post_comment_id) AS `Post friend comment number`
    FROM
        friends f
        INNER JOIN users u ON (f.user_id1 = u.user_id OR f.user_id2 = u.user_id)
        INNER JOIN posts pst ON (pst.user_id = u.user_id AND pst.post_type = 'profile')
        LEFT JOIN reactions rct ON (rct.reaction_type = 'profil' AND rct.reaction_type_id = pst.post_id AND rct.user_id = 1)
        LEFT JOIN posts_comments cmt ON (cmt.post_id = pst.post_id)
    WHERE
        (f.user_id1 = 1 OR f.user_id2 = 1) AND f.user_relation = 'friend'
    GROUP BY
        u.user_firstname, u.user_lastname, u.user_username, pst.post_id, pst.post_content
");

$requete->execute();

}