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
    <link rel="stylesheet" type="text/css" href="./styles/feed.css">
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
        <img src="" alt="commentary">
        <img src="" alt="coeur">
        <span class="like"><?php echo "likes"; ?></span>
        <span class="commentaire"><?php echo "nombre de commentaire"; ?></span>
    </article>

    <section id="userFeed">
<!--        --><?php //= foreach($allPosts as $post):?>
        <div class="postCard">
            <div class="cardHeader">
                <img src="./assets/imgs/users/picture/<?= "mockuser.svg"?>" alt="Image de l'utilisateur">
                <div>
                    <span class="cardUserName"><?= "@ossian_t"?></span>
                    <span><?= "2 minutes ago"?></span>
                </div>
            </div>
            <div class="cardBody">
                <p>Everywhere I go, fuck Barbosa.</p>
                <form class="cardCta" method="post">
                    <input type="image" src="./assets/icons/commentary.svg" name="comment">
                    <input type="image" src="./assets/icons/like.svg" name="like">
                </form>
            </div>
            <div class="cardFooter">
                <p>Aimé par <?= "9329 autres personnes" ?></p>
                <p><?= "512"?> commentaires</p>
            </div>
        </div>
    </section>
</body>
</html>
