<?php 
require_once("../controllers/functions.php");
$post = getUserPosts(1); // Utilise getUserPosts au lieu de getUserPoser
var_dump($post);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed - <?php echo "TON NOM"; ?></title>
</head>
<body>
    <?php require_once("./templates/side_profile.php"); ?>
    <article>
        <img src="<?= '' ?>" alt="friend_pp" />
        <span><?php echo "friend_pseudo"; ?><span> 
        <p><?php echo "post_date"; ?></p>
        <p><?php echo "post_content"; ?></p>
        <img src="./assets/icons/commentary.svg" alt="commentary">
        <img src="./assets/icons/like.svg" alt="coeur">
        <span class="like"><?php echo "likes"; ?></span>
        <span class="commentaire"><?php echo "nombre de commentaire"; ?></span>
    </article>
</body>
</html>
