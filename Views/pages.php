<?php
require('../Controllers/PageController.php');
require ('../Controllers/FeedController.php');

use Feed\FeedController;
use Page\PageController;

$pageController = new PageController();
$feedController = new FeedController();
$username = $feedController->getUserName();
$renderData = $pageController->getAllPagesData();
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

    <section id="pagesLayout">
        <h2>Mes Pages</h2>
        <div class="layout">
            <?php if(!$renderData["myPages"]): ?>
                <span>Vous n'êtes admin d'aucune page. N'hésitez pas à en créer une.</span>
            <?php endif;?>

            <?php foreach ($renderData['myPages'] as $page): ?>
                <div class="userCard">
                    <div>
                        <h2><?= $page["name"] ?></h2>
                        <span>@<?= $page["at"]?></span>
                        <p><?= $page["bio"]?></p>
                    </div>
                    <a href="http://localhost/projet-rs-hetic/public/index.php?p=page&page_id=<?= $page["id"]?>" class="username"> Voir la page</a>
                </div>
            <?php endforeach; ?>
        </div>

        <h2>Pages suivies</h2>
        <div class="layout">
            <?php if(!$renderData["followed"]): ?>
                <span>Vous ne suivez aucune page. N'hésitez pas à en découvrir par la recherche.</span>
            <?php endif;?>

            <?php foreach ($renderData['followed'] as $page): ?>
                <div class="userCard">
                    <div>
                        <h2><?= $page["name"] ?></h2>
                        <span>@<?= $page["at"]?></span>
                        <p><?= $page["bio"]?></p>
                    </div>
                    <a href="http://localhost/projet-rs-hetic/public/index.php?p=page&page_id=<?= $page["id"]?>" class="username"> Voir la page</a>
                </div>
            <?php endforeach; ?>

        </div>
    </section>
</main>
</body>
</html>
