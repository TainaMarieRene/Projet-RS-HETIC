<?php
require ('../Controllers/FeedController.php');
require ('../Controllers/SearchController.php');

use Feed\FeedController;
use Search\SearchController;

$searchFilter = $_GET["filter"];
$searchController = new SearchController();

$renderData = $searchController->getAccounts($searchFilter);
$username = (new FeedController())->getUserName();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Views/styles/style.css">
    <link rel="stylesheet" type="text/css" href="../Views/styles/search.css">

    <title>Search</title>
</head>

<body>
    <?php include '../Views/templates/header.php'; ?>
    <main>
        <?php require_once("../Views/templates/side_profile.php"); ?>
        <section id="searchFeed">
            <div class="accountRadio">
                <div class="labelAccount">
                    <label for="userType">Utilisateurs</label>
                    <input type="radio" name="accountType" id="userType" value="users" checked>
                </div>
                <div class="labelAccount">
                    <label for="pageType">Pages</label>
                    <input type="radio" name="accountType" id="pageType" value="pages">
                </div>

            </div>
            <div id="users">
                <?php if(!$renderData["users"]): ?>
                    <span>Aucun utilisateur n'a ce nom. Vérifiez dans les pages.</span>
                <?php endif;?>

                <?php foreach ($renderData["users"] as $user): ?>
                <div class="userCard">
                    <div>
                        <h2><?= $user["name"] ?></h2>
                        <span>@<?= $user["at"]?></span>
                    </div>
                    <a href="http://localhost/projet-rs-hetic/public/index.php?p=profile&profile_id=<?=$user["id"]?>" class="username"> Voir le profil</a>
                </div>
                <?php endforeach; ?>
            </div>
            <div id="pages">
                <?php if(!$renderData["pages"]): ?>
                    <span>Aucune page n'a ce nom. Vérifiez dans les utilisateurs.</span>
                <?php endif;?>
                <?php foreach ($renderData["pages"] as $page): ?>
                    <div class="pageCard">
                        <div>
                            <h2><?= $page["name"] ?></h2>
                            <span>@<?= $page["at"]?></span>
                        </div>
                        <a href="http://localhost/projet-rs-hetic/public/index.php?p=page&page_id=<?= $page["id"]?>" class="username"> Voir la page</a>
                    </div>
                <?php endforeach;?>
            </div>
        </section>
    </main>
</body>
<script src="../Views/script/search.js"></script>