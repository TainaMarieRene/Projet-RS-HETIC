<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Views/styles/style.css">
    <link rel="stylesheet" type="text/css" href="../Views/styles/userOptions.css">
    <title>UniLink | <?= $this->_page; ?></title>
</head>
<body>
    <header>
        <h1><img src="../Views/assets/imgs/website/unilink_logo.svg" alt="UniLink Logo" class="logo"></h1>
        <h2>OPTIONS</h2>
    </header>
    <nav>
        <a href="index.php?p=profile&profile_id=<?= $_COOKIE['uniCookieUserID'] ?>">Profile</a>
        <a href="index.php?p=feed">Feed</a>
        <a href="index.php?p=updateProfileStatus&type=<?php if($profile["profile_status"] == "public"){ echo("private"); } else { echo("public"); } ?>"><?php if($profile["profile_status"] == "public"): ?> Passer en privé <?php else: ?> Passer en public <?php endif; ?></a>
        <a href="index.php?p=logout&type=device">Deconnexion</a>
        <a href="index.php?p=logout&type=allDevice">Deconnexion Global</a>
        <?php if($user["user_account_status"] != "waiting"): ?>
            <a href="index.php?p=updateAccountStatus&type=<?php if($user["user_account_status"] == "valid"){ echo("disable"); } else { echo("valid"); } ?>"><?php if($user["user_account_status"] == "valid"): ?> Désactiver le compte <?php else: ?> Reactiver le compte<?php endif; ?></a>
        <?php else: ?>
            <span>N'oubliez pas de valider votre compte ! </span><a href="index.php?p=resendMail">Renvoyer le mail</a>
        <?php endif; ?>
        <a href="index.php?p=deleteAccount">Supprimer le compte</a>
    </nav>

    <div class="user-options">
        <?php if($this->_success): ?>
            <div class="success"><?= $this->_success ?></div>
        <?php elseif($this->_error): ?>
            <div class="error"><?= $this->_error ?></div>
        <?php endif; ?>
        <form class="user-info" enctype="multipart/form-data" method="POST">
            <label for="username">Nom d'utilisateur</label>
            <input type="text" name="userName" value="<?= $user["user_username"]?>">
            <label for="mail">Mail</label>
            <input type="text" name="userMail" value="<?= $user["user_mail"]?>">
            <label for="current-password">Mot de passe</label>
            <input type="password" name="currentPassword" placeholder="Mot de passe actuel">
            <input type="password" name="password1" placeholder="Nouveau mot de passe">
            <input type="password" name="password2" placeholder="Confirmer nouveau mot de passe">
            <label for="firstname">Prénom</label>
            <input type="text" name="userFirstname" value="<?= $user["user_firstname"]?>">
            <label for="lastname">Nom</label>
            <input type="text" name="userLastname" value="<?= $user["user_lastname"]?>">
            <label for="birthdate">Date de naissance</label>
            <input type="date" name="userBirthdate" value="<?= $user["user_birthdate"]?>">
            <label for="profile-bio">Bio</label>
            <input type="text" name="profileBio" value="<?= $profile["profile_bio"]; ?>" placeholder="Dites nous en plus...">
            <label for="location">Ville</label>
            <input type="text" name="profileLocation" value="<?= $profile["profile_location"]; ?>" placeholder="Ville, Pays...">
            <label for="activity">Profession</label>
            <input type="text" name="profileActivity" value="<?= $profile["profile_activity"]; ?>" placeholder="Etudiant, Dev...">
            <label for="profile_picture" class="mediaInput">Modifier votre photo de profil<img alt="Media Icon" src="../Views/assets/imgs/users/picture/<?= $profile["profile_picture"] ?>"></label>
            <input type="file" name="profile_picture" id="profile_picture">
            <label for="profile_banner" class="mediaInputBanner">Modifier votre bannière<img alt="Media Icon" src="../Views/assets/imgs/users/banner/<?= $profile["profile_banner"] ?>"></label>
            <input type="file" name="profile_banner" id="profile_banner">
            <input type="submit" value="Valider" class="validate">
        </form>
    </div>

</body>
</html>