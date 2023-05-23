<?php

//if (!isset($_COOKIE["user_id"])) {
//    header("Location: login.php");
//    exit();
//}

require ('../Models/Database.php');
require('../Controllers/FeedController.php');
use Feed\FeedController;

$feedController = new FeedController();
$username = $feedController->getUserName();
$actionMsg = "";
if (isset($_POST['postPost'])) {
    if ($_POST['postContent']) {
        $actionMsg = $feedController->createUserPost($_POST['postContent']);
    } else {
        $actionMsg = 'Can\'t post nothing !';
    }
}
$commentMSG = "";
if(isset($_POST['postComment'])){
    if($_POST['commentContent']){
        $commentMSG = $feedController->createComment($_POST['postComment']);
    } else{
        $commentMSG = 'Can\'t post nothing !';
    }
}
$id = 0 
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/style.css">
    <link rel="stylesheet" type="text/css" href="./styles/feed.css">
    <title>Feed -
        <?php echo $feedController->getUserName(); ?>
    </title>
</head>

<body>
    <?php include './templates/header.php'; ?>
    <main>
        <?php require_once("./templates/side_profile.php"); ?>

        <section id="userFeed">
            <p id="actionMsg"><?= $actionMsg ?></p>
            <p id="commentMSG"><?= $commentMSG ?></p>
            <form class="postCta" method="post">
                <label for="postContent" class="hiddenLabel">Create Post Content Label</label>
                <input type="text" name="postContent" id="postContent" placeholder='Quoi de neuf ?'>
                <label for="inputImage" class="mediaInput"><img alt="Media Icon" src="assets/icons/media.svg"></label>
                <input type="file" name="inputImage" id="inputImage">
                <button name="postPost">Post</button>
            </form>
            <?php foreach ($feedController->getFeedPosts() as $post): ?>
                <div class="postCard">
                    <div class="cardHeader">
                        <img src="./assets/imgs/users/picture/<?= "default_picture.jpg" ?>" alt="Image de <?= $post["author"]?>">
                        <div>
                            <span class="cardUserName">
                                <?= $post["Friends Pseudo"] ?? $post["author"] ?>
                            </span>
                            <span>
                                <?= $feedController->getDateDiff($post["date"]) ?>
                            </span>
                        </div>
                    </div>
                    <div class="cardBody">
                        <p>
                            <?= $post["content"] ?>
                        </p>
                        <form class="hideCta" id=<?='reactionCta' . $id ?> method="post">
                            <input type='image' src='./assets/icons/smiley-bad.svg' name="bad" alt="Angry Face">
                            <input type='image' src='./assets/icons/smiley-crying-rainbow.svg' name="crying" alt="Crying Face">
                            <input type='image' src='./assets/icons/smiley-drop.svg' name="drop" alt="Drop Face">
                            <input type='image' src='./assets/icons/smiley-in-love.svg' name="love" alt="heart in eyes Face">
                            <input type='image' src='./assets/icons/smiley-lol-sideways.svg' name="lol" alt="Laughing face">
                        </form>
                        <form class="cardCta" method="post">
                            <input id=<?= "commentButton" . $id ?> type="image" src="./assets/icons/commentary.svg" name="comment" alt="Comment Icon">
                            <input id=<?= "likeButton" . $id ?> type="image" src="./assets/icons/like.svg" name="like" alt="Like Icon">
                        </form>
                        <form class="commentForm hideCta" id=<?='comment' . $id ?> method="post">
                            <input type="text" name="commentContent "placeholder="ratio">
                            <button name="postComment">Comment</button>
                        </form>
                    </div>
                    <div class="cardFooter">
                        <p>
                            <?= $post["likesCount"] ?> ont aimé ce post
                        </p>
                        <p>
                            <?= $post["commentsCount"] ?> commentaires
                        </p>
                    </div>
                </div>
                <?php $id++ ?>
            <?php endforeach; ?>
        </section>
    </main>
</body>
<script>
    let actionState = "<?= $actionMsg ?>"
    if (!actionState) {
        document.getElementById("actionMsg").classList.add('hide');
    } else {
        document.getElementById("actionMsg").classList.remove('hide');
        setTimeout(() => {
            document.getElementById("actionMsg").classList.add('hide');
        }, 1500)
    }
    let commentMSG = "<?= $commentMSG ?>"
    if (!commentMSG) {
        document.getElementById("commentMSG").classList.add('hide');
    } else {
        document.getElementById("commentMSG").classList.remove('hide');
        setTimeout(() => {
            document.getElementById("commentMSG").classList.add('hide');
        }, 1500)
    }

/*
NOTE PERSO ALESS (ne pas faire attention ni toucher, je corrigerai by myself)

- l'animation fonctionne sur tous les posts MAIS se display and hide super vite 

*/

</script>
<script src="./script/feed.js"></script>
</html>