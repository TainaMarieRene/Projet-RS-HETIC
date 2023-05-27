<?php

require ('../Controllers/PostPageController.php');
require ('../Controllers/FeedController.php');

use Feed\FeedController;
use Post\PostPageController;

$postPageController = new PostPageController();
$postData = $postPageController->renderData();
$feedController = new FeedController();
$username = $feedController->getUserName();

$commentMSG = "";

if (isset($_POST['postComment'])) {
    if ($_POST['commentContent']) {
        $postId = $_POST["postId"];
        $userId = $_POST["userId"];
        $parentId = $_POST["parentId"];
        $content = $_POST["commentContent"];
        $feedController->postComment($postId, $userId, $parentId, $content);
        $refresh = 'Location: '. (empty($_SERVER['HTTPS']) ? 'http' : 'https') . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        header($refresh);
    } else {
        $commentMSG = 'Can\'t post nothing !';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Views/styles/style.css">
    <link rel="stylesheet" type="text/css" href="../Views/styles/post.css">
    <link rel="stylesheet" type="text/css" href="../Views/styles/feed.css">

    <title>Post -
        <?= $postPageController->postId ?>
    </title>
</head>

<body>
<?php include '../Views/templates/header.php'; ?>
    <main>
        <?php require_once("../Views/templates/side_profile.php"); ?>
        <section id="postFeed">
            <p id="commentMSG">
                <?= $commentMSG ?>
            </p>

            <div class="postCard">
                <div class="cardHeader">
                <img src="../Views/assets/imgs/users/picture/<?= "default_picture.jpg" ?>" alt="Image de <?= $postData["postData"]["author"] ?>">
                    <div>
                        <span class="cardUserName">
                            <?php if($_GET["type"] == "page"): ?>
                            <a href="http://localhost/projet-rs-hetic/public/index.php?p=page&page_id=<?=$postData["postData"]["author_id"]?>">
                                <?= $postData["postData"]["author"] ?>
                            </a>
                            <?php else: ?>
                                <a href="http://localhost/projet-rs-hetic/public/index.php?p=profile&profile_id=<?=$postData["postData"]["author_id"]?>">
                                <?= $postData["postData"]["author"] ?>
                            </a>

                            <?php endif;?>
                        </span>
                        <span>
                            <?= $feedController->getDateDiff($postData["postData"]["date"]) ?>
                        </span>
                    </div>
                </div>
                <div class="cardBody">
                    <p>
                        <?= $postData["postData"]["content"]?>
                    </p>
                </div>
                <?php if($_COOKIE['uniCookieUserID'] != $postData["postData"]["author_id"]):?>
                <form class="cardCta" method="post">
                    <input class="likeButton" id= "likeButton<?=$postPageController->postId?>" type="image"
                           src="../Views/assets/icons/like.svg" name="like" alt="Like Icon">
                </form>
                <?php endif; ?>
                <form class="commentForm" id= 'comment<?=$postPageController->postId?>' method="post">
                    <input type="hidden" name="postId" value="<?= $postPageController->postId ?>">
                    <input type="hidden" name="parentId" value="<?= $parentId = 1 ?>">
                    <input type="hidden" name="userId" value="<?= $_COOKIE['uniCookieUserID'] ?>">
                    <textarea name="commentContent" class="commentContent" rows="1"></textarea>
                    <input type="submit" class="postComment" name="postComment" value="Commenter">
                </form>
                <div class="cardComments">
                    <p>reactions</p>
                    <p>commentaires</p>
                    <?php foreach($postData["commentsData"] as $commentData): ?>
                        <div class="commentCard">
                            <div class="commentHeader">
                                <img src="../Views/assets/imgs/users/picture/default_picture.jpg" width="64px" alt="Image de <?= $commentData["author"] ?>">
                            </div>
                            <div class="commentCardBody">
                                <p><?= $commentData["content"] ?></p>
                                <p><a href="http://localhost/projet-rs-hetic/public/index.php?p=profile&profile_id=<?=$commentData["author_id"]?>">@<?= $commentData["author"] ?></a> <?=$feedController->getDateDiff($commentData["date"])?></p>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
