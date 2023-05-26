<?php
require ('../Controllers/FeedController.php');
require ('../Controllers/PageController.php');

use Feed\FeedController;
use Page\PageController;

$username = (new FeedController())->getUserName();
$pageController = new PageController();

$pageData = $pageController->getSinglePageData();

if (isset($_POST["unfollow"])) {
    $pageController->unfollow();
}

if (isset($_POST["follow"])) {
    $pageController->follow();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Views/styles/style.css">
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


        </section>
    </main>
</body>
</html>
