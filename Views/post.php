<?php

require ('../Models/Database.php');
require ('../Controllers/PostPageController.php');
use Post\PostPageController;

$postPageController = new PostPageController();
$postData = $postPageController->renderData();

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
<?php //include './templates/header.php'; ?>
<main>
    <?php require_once("./templates/side_profile.php"); ?>
    <section id="postFeed">
        <?=$postData["postData"]["author"] ?>
    </section>
</main>
</body>

