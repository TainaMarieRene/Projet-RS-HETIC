<?php 
require_once("../controllers/functions.php");
$post = getUserPosts(1); // Utilise getUserPosts au lieu de getUserPoser
$test = getPostsFromPage(1);
$allPosts = array_merge($post, $test);

function getDateDiff(string $postDate) {
    try {
        $postDateTime = new DateTime($postDate);
        $currentDateTime = new DateTime();

        $interval = $postDateTime->diff($currentDateTime);

        $minutes = $interval->days * 24 * 60 + $interval->h * 60 + $interval->i;

        echo $minutes;

    } catch (Exception $e) {
        var_dump($e);
    }

}
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
        <?php foreach($allPosts as $post): ?>
        <div class="postCard">
            <div class="cardHeader">
                <img src="./assets/imgs/users/picture/<?= "mockuser.svg"?>" alt="Image de l'utilisateur">
                <div>
                    <span class="cardUserName"><?= $post["Friends Pseudo"] ?? $post["page at"] ?></span>
                    <span><?= isset($post["Post friend date"]) ? getDateDiff($post["Post friend date"]) : getDateDiff($post["Post Page date"])  ?> minutes ago</span>
                </div>
            </div>
            <div class="cardBody">
                <p><?= $post["Post friend content"] ?? $post["Post page content"]?></p>
                <form class="cardCta" method="post">
                    <input type="image" src="./assets/icons/commentary.svg" name="comment">
                    <input type="image" src="./assets/icons/like.svg" name="like">
                </form>
            </div>
            <div class="cardFooter">
                <p>Aimé par <?= $post["Post friend like"] ?? $post["Post page like"]?> autres personnes</p>
                <p><?= $post["Post friend comment number"] ?? $post["Post page comment number"]?> commentaires</p>
            </div>
        </div>
        <?php endforeach; ?>
    </section>
</body>
</html>
