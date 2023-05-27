<?php
require ('../Controllers/FeedController.php');
require ('../Controllers/PageController.php');

use Feed\FeedController;
use Page\PageController;

$feedController = new FeedController();
$username = ($feedController)->getUserName();
$pageController = new PageController();
$pageData = $pageController->getSinglePageData();
$errorMsg = "";
$successMsg = "";
if (isset($_POST['postPost'])) {
    if ($_POST['postContent']) {
        $pageController->createPagePost($_POST['postContent']);
        header("Refresh:0");
        exit();
    } else {
        $errorMsg = 'Can\'t post nothing !';
    }
}

if (isset($_POST["unfollow"])) {
    $pageController->unfollow();
    header("Refresh:0");
}

if (isset($_POST["follow"])) {
    $pageController->follow();
    header("Refresh:0");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Views/styles/style.css">
    <link rel="stylesheet" type="text/css" href="../Views/styles/feed.css">
    <link rel="stylesheet" type="text/css" href="../Views/styles/pages.css">
    <title>My pages</title>
</head>

<body>
<?php include '../Views/templates/header.php'; ?>
    <main>
        <?php require_once("../Views/templates/side_profile.php"); ?>
        <section id="pageLayout">
            <div class="headerPage">
                <img src="../Views/assets/imgs/users/picture/default_picture.jpg" width="64px" alt ="default pic">
                <h1><?= $pageData["info"]["name"]?></h1>
                <span>@<?= $pageData["info"]["at"]?></span>
                <p><?= $pageData["info"]["bio"]?></p>
                <p><?= $pageData["info"]["followersCount"]?> abonnés</p>
                <form method="post" class="pageCta">
                    <?php if(!$pageController->isFollower()): ?>
                        <button name="follow" id="follow" class="headerCTA">S'abonner</button>
                    <?php else: ?>
                        <button name="unfollow" id="unfollow" class="headerCTA unfollow">Se désabonner</button>
                    <?php endif; ?>
                    <?php if($pageController->isAdmin()):?>
                        <button name="adminSettings" id="adminSettings" class="headerCTA">Réglages ADMIN</button>
                    <?php endif;?>
                </form>
            </div>
            <?php if($pageController->isAdmin()):?>
            <div id="adminPostAction">
                <div class="error" id="errorMsg">
                    <?= $errorMsg ?>
                </div>
                <div class="success" id="succesMsg">
                    <?= $successMsg ?>
                </div>
                <form class="postCta" method="post">
                    <label for="postContent" class="hiddenLabel">Create Post Content Label</label>
                    <input type="text" name="postContent" id="postContent" placeholder='Quoi de neuf ?'>
                    <label for="inputImage" class="mediaInput"><img alt="Media Icon"
                                                                    src="../Views/assets/icons/media.svg"></label>
                    <input type="file" name="inputImage" id="inputImage">
                    <button name="postPost">Post</button>
                </form>
            </div>
            <?php endif;?>
            <div id="postCards">
                <?php foreach ($pageData["posts"] as $post): ?>
                <?php if($post["id"]): ?>
                    <div>
                        <?php if($pageController->isAdmin()):?>
                            <?php
                                if (isset($_POST["delete".$post["id"]])) {
                                    $pageController->deletePost($post["id"]);
                                    $successMsg = "Post delete successfully, refresh the page to see the changes.";
                                }
                            ?>
                            <form method="post" class="postDelete">
                                <button name="delete<?= $post["id"]?>" class="headerCTA unfollow">
                                    Supprimer le post
                                </button>
                            </form>
                        <?php endif; ?>
                        <div class="postCard">
                            <div class="cardHeader">
                                <img src="../Views/assets/imgs/users/picture/<?= "default_picture.jpg" ?>" alt="Image de <?= $pageData["info"]["name"] ?>">
                                <div>
                                    <span class="cardUserName">
                                        <?= $pageData["info"]["name"] ?>
                                    </span>
                                    <span class="cardDate">
                                    <?= $feedController->getDateDiff($post["date"]) ?>
                                </span>
                                </div>
                            </div>
                            <div class="cardBody">
                                <p>
                                    <?= $post["content"] ?>
                                </p>
                            </div>

                        </div>
                    <?php endif; ?>

                    </div>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
</body>
<script>
    const error = "<?= $errorMsg ?>";
    const success = "<?= $successMsg ?>";
    if (!error) {
        document.getElementById("errorMsg").classList.add('hide')
    } else{
        document.getElementById("errorMsg").classList.remove('hide');
        setTimeout(() => {
            document.getElementById("errorMsg").classList.add('hide');
        }, 1500)
    }

    if (!success) {
        document.getElementById("succesMsg").classList.add('hide')
    } else{
        document.getElementById("succesMsg").classList.remove('hide');
        setTimeout(() => {
            document.getElementById("succesMsg").classList.add('hide');
        }, 1500)
    }


</script>
</html>
