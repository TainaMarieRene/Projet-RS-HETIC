<?php

require ('../Controllers/PostPageController.php');
require ('../Controllers/FeedController.php');

use Feed\FeedController;
use Post\PostPageController;

$postPageController = new PostPageController();
$postData = $postPageController->renderData();
$feedController = new FeedController();
$username = $postPageController->getUserName();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Views/styles/style.css">
    <link rel="stylesheet" type="text/css" href="../Views/styles/post.css">
    <title>Post -
        <?= $postPageController->postId ?>
    </title>
</head>

<body>
<?php include '../Views/templates/header.php'; ?>
<main>
    <?php require_once("../Views/templates/side_profile.php"); ?>
    <section id="postFeed">
        <?=$postData["postData"]["author"] ?>
        <div class="postCard">
            <div class="cardHeader">
            <img src="../Views/assets/imgs/users/picture/<?= "x.jpg" ?>" alt="Image de <?= $postData["postData"]["author"] ?>">
                <div>
                    <span class="cardUserName">
                        <?= $postData["postData"]["author"] ?>
                    </span>
                    <span>
                        <?= $feedController->getDateDiff($postData["postData"]["date"]) ?>
                    </span>
                </div>
            </div>
        </div>
    </section>
</main>
</body>

