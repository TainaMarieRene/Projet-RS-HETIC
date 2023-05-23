<?php

include '../Controllers/profileController.php';

$info = getUserInfo(27);

$infoName = getUserName(27);

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./styles/header.css">
    <link rel="stylesheet" href="./styles/profile.css">
    <link rel="stylesheet" href="./styles/style.css">
    <title>Profile - <?php echo "TON NOM";?></title>
</head>
<body>
    
    <section>
        <img src=".\assets\imgs\users\banner\<?= $info["profile_banner"]; ?>" alt="bannière">
            <div class="profile-block">
                <img src=".\assets\imgs\users\picture\<?= $info["profile_picture"]; ?>" alt="photo de profil" id="picture">
                <span>
                    <?= $infoName["user_firstname"]?>
                </span>
                <span>
                <?= $infoName["user_lastname"]?>
                </span>
                <span>
                <?= $infoName["user_username"]?>
                </span>
                <span>
                    <?= $info["profile_bio"]; ?>
                </span>
                <span>
                    <?= $info["profile_location"]; ?>
                </span>
                <span>
                    <?= $info["profile_activity"]; ?>
                </span>
            </div>
    </section>
    
</body>
</html>