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
        pst.post_date AS `Post friend date`,
        COUNT(rct.user_id) AS `Post friend like`,
        COUNT(cmt.post_comment_id) AS `Post friend comment number`
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

$requete->execute([
    "userId"=>$userId
]);

    $posts = $requete->fetchAll(PDO::FETCH_ASSOC);

    return $posts;
}

function getPostsFromPage(int $userId) {
    $pdo = db();
    $requere = $pdo->prepare("SELECT
  pg.page_name AS 'Page pp',
  pg.page_at AS 'page at',
  pst.post_id AS 'Post page',
  pst.post_content AS 'Post page content',
  pst.post_date AS 'Post Page date',
  COUNT(rct.user_id) AS 'Post page like',
  COUNT(cmt.post_comment_id) AS 'Post page comment number'
FROM
  members m
  INNER JOIN pages pg ON m.member_type_id = pg.page_id
  LEFT JOIN posts pst ON (pst.post_type = 'page' AND pst.post_type_id = pg.page_id)
  LEFT JOIN reactions rct ON (rct.reaction_type = 'page' AND rct.reaction_type_id = pg.page_id AND rct.user_id = 1)
  LEFT JOIN posts_comments cmt ON (cmt.post_id = pst.post_id)
WHERE
  m.user_id = :userId
GROUP BY
  pg.page_name, pg.page_at, pst.post_id, pst.post_content;");
    $requere->execute([
        ":userId"=>$userId
    ]);

    return $requere->fetchAll();
}

function postImage(){
    $pdo = db();
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

function getImage(){

}
