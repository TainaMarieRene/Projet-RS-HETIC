<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniLink | <?= $this->_page; ?></title>
    <link rel="stylesheet" href="../Views/styles/style.css">
    <link rel="stylesheet" href="../Views/styles/profile.css">
</head>
<body class="login">
    <section>
        <img src="../Views/assets/imgs/users/banner/<?= $profile["profile_banner"]; ?>" alt="bannière">
            <div class="profile-block">
                <img src="../Views/assets/imgs/users/picture/<?= $profile["profile_picture"]; ?>" alt="photo de profil" id="picture">
                <!-- <span>
                    <= $infoName["user_firstname"]?>
                </span>
                <span>
                <= $infoName["user_lastname"]?>
                </span>
                <span>
                <= $infoName["user_username"]?>
                </span> --> 
                <span>
                    <?= $profile["profile_bio"]; ?>
                </span>
                <span>
                    <?= $profile["profile_location"]; ?>
                </span>
                <span>
                    <?= $profile["profile_activity"]; ?>
                </span>
            </div>
    </section>
</body>
</html>