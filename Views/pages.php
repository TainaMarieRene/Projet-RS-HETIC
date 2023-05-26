<?php
require('../Controllers/PageController.php');
require ('../Controllers/FeedController.php');

use Feed\FeedController;
use Page\PageController;

$pageController = new PageController();
$feedController = new FeedController();
$username = $feedController->getUserName();

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
        here are my pages & the pages  i follow
    </section>
</main>
</body>
</html>
