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
    <h1>OPTIONS</h1>
    <p>Options temporaire pour réaliser des tests</p>
    <?php if($user["user_account_status"] != "waiting"): ?>
        <a href="index.php?p=updateAccountStatus&type=<?php if($user["user_account_status"] == "valid"){ echo("disable"); } else { echo("valid"); } ?>"><?php if($user["user_account_status"] == "valid"){ echo("Disable Account"); } else { echo("Reactivate Account"); } ?></a>
    <?php else: ?>
        <span>N'oubliez pas de valider votre compte ! </span><a href="index.php?p=resendMail">Renvoyer le mail</a>
    <?php endif; ?>
    <a href="index.php?p=deleteAccount">Delete Account</a>
    <br>
    <a href="index.php?p=feed">Feed</a>
    <a href="index.php?p=logout&type=device">Lougout</a>
    <a href="index.php?p=logout&type=allDevice">Lougout all device</a>

    <div>
        <?php if($this->_success): ?>
            <div class="success"><?= $this->_success ?></div>
        <?php elseif($this->_error): ?>
            <div class="error"><?= $this->_error ?></div>
        <?php endif; ?>
        <form class="user-info" action="" method="POST">
            <input type="text" name="userName" value="<?= $user["user_username"]?>">
            <input type="text" name="userMail" value="<?= $user["user_mail"]?>">
            <input type="password" name="currentPassword" placeholder="Mot de passe actuel">
            <input type="password" name="password1" placeholder="Nouveau mot de passe">
            <input type="password" name="password2" placeholder="Confirmer nouveau mot de passe">
            <input type="text" name="userFirstname" value="<?= $user["user_firstname"]?>">
            <input type="text" name="userLastname" value="<?= $user["user_lastname"]?>">
            <input type="date" name="userBirthdate" value="<?= $user["user_birthdate"]?>">
            <input type="submit" value="Valider">
        </form>
    </div>

</body>
</html>