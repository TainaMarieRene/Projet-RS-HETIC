<?php
require('../Controllers/FeedController.php');
use Feed\FeedController;

$feedController = new FeedController();
$username = $feedController->getUserName();
$actionMsg = "";
if (isset($_POST['postPost'])) {
    if ($_POST['postContent']) {
        $actionMsg = $feedController->createUserPost($_POST['postContent']);
        header('Location: http://localhost/projet-rs-hetic/public/index.php?p=feed', true, 303);
        exit();
    } else {
        $actionMsg = 'Can\'t post nothing !';
    }
}
$commentMSG = "";

if (isset($_POST['postComment'])) {
    if ($_POST['commentContent']) {
        $postId = $_POST["postId"];
        $userId = $_POST["userId"];
        $parentId = $_POST["parentId"];
        $content = $_POST["commentContent"];

        $commentMSG = $feedController->postComment($postId, $userId, $parentId, $content);
        header('Location: http://localhost/projet-rs-hetic/public/index.php?p=feed', true, 303);
        exit();
    } else {
        $commentMSG = 'Can\'t post nothing !';
    }
}


if (isset($_POST["reaction"])) {
    $reactionType = $_POST['postType'];
    $userId = $_COOKIE['uniCookieUserID'];
    $reactionTypeId = $_POST['postId'];
    $reactionEmoji = $feedController->filterReaction($_POST["reaction"]);

    $feedController->saveReaction($userId, $reactionType, $reactionEmoji, $reactionTypeId);
    header('Location: http://localhost/projet-rs-hetic/public/index.php?p=feed', true, 200);
    exit();
}


$userId = $_COOKIE['uniCookieUserID'];
$id = 0;
$likeId = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Views/styles/style.css">
    <link rel="stylesheet" type="text/css" href="../Views/styles/feed.css">
    <title>Feed -
        <?php echo $feedController->getUserName(); ?>
    </title>
</head>

<body>
    <?php include '../Views/templates/header.php'; ?>
    <main>
        <?php if (filter_input(INPUT_GET, "success") && preg_match("`^(valid)$`", filter_input(INPUT_GET, "success"))): ?>
            <div class="success">Mail validé</div>
        <?php elseif (filter_input(INPUT_GET, "success") && preg_match("`^(error)$`", filter_input(INPUT_GET, "success"))): ?>
            <div class="error">Erreur durant la validation du mail, veuillez ressayer</div>
        <?php endif; ?>
        <?php require_once("../Views/templates/side_profile.php"); ?>

        <section id="userFeed">
            <div class="error" id="actionMsg">
                <?= $actionMsg ?>
            </div>
            <div class="error" id="commentMSG">
                <?= $commentMSG ?>
            </div>
            <form class="postCta" method="post">
                <label for="postContent" class="hiddenLabel">Create Post Content Label</label>
                <input type="text" name="postContent" id="postContent" placeholder='Quoi de neuf ?'>
                <label for="inputImage" class="mediaInput"><img alt="Media Icon"
                        src="../Views/assets/icons/media.svg"></label>
                <input type="file" name="inputImage" id="inputImage">
                <button name="postPost">Post</button>
            </form>
                <?php foreach ($feedController->getFeedPosts() as $post): ?>
                    <div class="postCard">
                        <div class="cardHeader">
                            <img src="../Views/assets/imgs/users/picture/<?= "default_picture.jpg" ?>"
                                alt="Image de <?= $post["author"] ?>">
                            <div>
                                <?php if ($post["type"] == "page"): ?>
                                <a href="http://localhost/projet-rs-hetic/public/index.php?p=page&page_id=<?=$post["author_id"]?>">
                                <?php else: ?>
                                <a href="http://localhost/projet-rs-hetic/public/index.php?p=profile&profile_id=<?=$post["author_id"]?>">
                                <?php endif;?>

                                    <span class="cardUserName">
                                        <?= $post["author"] ?>
                                        <?php if ($post["type"] == "page"): ?>
                                            (page suivie)
                                        <?php endif;?>

                                    </span>
                                </a>
                                <span class="cardDate">
                                    <?= $feedController->getDateDiff($post["date"]) ?>
                                </span>
                            </div>
                        </div>
                        <div class="cardBody">
                            <p>
                                <?= $post["content"] ?>
                            </p>

                            <form class="hideCta reactionCta" id=<?= 'reactionCta' . $id ?> method="post">
                                <input type="hidden" name="postId" value="<?= $post['id'] ?>">
                                <input type="hidden" name="postType" value="<?= $post['type'] ?>">
                                <button type="submit" name="reaction" value="bad"><img
                                        src="../Views/assets/icons/smiley-bad.svg" alt="Angry Face"></button>
                                <button type="submit" name="reaction" value="crying"><img
                                        src="../Views/assets/icons/smiley-crying-rainbow.svg" alt="Crying Face"></button>
                                <button type="submit" name="reaction" value="drop"><img
                                        src="../Views/assets/icons/smiley-drop.svg" alt="Drop Face"></button>
                                <button type="submit" name="reaction" value="love"><img
                                        src="../Views/assets/icons/smiley-in-love.svg" alt="heart in eyes Face"></button>
                                <button type="submit" name="reaction" value="lol"><img
                                        src="../Views/assets/icons/smiley-lol-sideways.svg" alt="Laughing face"></button>
                            </form>
                            <form class="cardCta" method="post">
                                <input class="displayForm" id=<?= "displayForm" . $id ?> type="image"
                                    src="../Views/assets/icons/commentary.svg" name="comment" alt="Comment Icon">
                                <input class="likeButton" id=<?= "likeButton" . $id ?> type="image"
                                    src="../Views/assets/icons/like.svg" name="like" alt="Like Icon">
                            </form>
                            <form class="hideCta commentForm" id=<?= 'comment' . $id ?> method="post">
                                <input type="hidden" name="postId" value="<?= $post['id'] ?>">
                                <input type="hidden" name="userId" value="<?= $userId ?>">
                                <input type="hidden" name="parentId" value="<?= $parentId = 1 ?>">
                                <textarea name="commentContent" class="commentContent" rows="1"></textarea>
                                <input type="submit" class="postComment" name="postComment" value="Commenter">
                            </form>
                        </div>
                        <div class="cardFooter">
                            <div class='displayReaction hideCta' id=<?= 'displayReaction' . $id ?>>
                                <ul class='reactionList'>
                                    <?php foreach ($feedController->getLike($post['id']) as $like): ?>
                                        <li class='reactionContent'>
                                            <img class="reactionEmoji <?= $like['reaction_emoji'] ?>" id=<?= 'reactionEmoji' . $likeId ?>
                                                src="" alt='image' />
                                            <span>
                                                <?= $like['user_firstname'] . " " . $like['user_lastname'] ?>
                                            </span>
                                        </li>
                                        <?php $likeId++ ?>
                                    <?php endforeach; ?>

                                    <ul>
                            </div>
                            <p>
                                <?= $post["likesCount"] ?> <button class='reactionButton' id=<?= 'reactionButton' . $id ?>>ont
                                    réagi à ce post</button>
                            </p>
                            <p>
                                <?= $post["commentsCount"] == 1 ? $post["commentsCount"]." commentaire" : $post["commentsCount"]." commentaires"?>
                            </p>
                        </div>
                        <a
                            href="http://localhost/projet-rs-hetic/public/index.php?p=post&id=<?= $post["id"] ?>&type=<?= $post['type'] ?>">
                            Voir plus...
                        </a>

                    </div>
                    <?php $id++ ?>
                <?php endforeach; ?>
        </section>
    </main>
</body>
<script src="../Views/script/feedController.js" type="module"></script>


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


</script>

</html>