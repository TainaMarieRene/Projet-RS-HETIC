<?php 
require_once("../controllers/functions.php");
$post = getUserPosts(1); // Utilise getUserPosts au lieu de getUserPoser
$test = getPostsFromPage(1);
$allPosts = array_merge($post, $test);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
    <title>Feed - <?php echo "TON NOM"; ?></title>
</head>
<body>
<?php include './templates/header.php'; ?>
    <?php require_once("./templates/side_profile.php"); ?>
    <article>
        <img src="<?= '' ?>" alt="friend_pp" />
        <span><?php echo "friend_pseudo"; ?><span> 
        <span><?php echo "post_date"; ?></span>
        <span><?php echo "post_content"; ?></span>
        <img src="./assets/icons/commentary.svg" alt="commentary">
        <img src="./assets/icons/like.svg" alt="coeur">
        <span class="like"><?php echo "likes"; ?></span>
        <span class="commentaire"><?php echo "nombre de commentaire"; ?></span>
    </article>
</body>
</html>
