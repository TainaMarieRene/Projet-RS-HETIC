<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniLink | <?= $this->_page; ?></title>
</head>
<body>
    <h1>OPTIONS</h1>
    <p>Options temporaire pour réaliser des tests</p>
    <?php if($this->_user["user_account_status"] != "waiting"): ?>
        <a href="index.php?p=updateAccountStatus&type=<?php if($this->_user["user_account_status"] == "valid"){ echo("disable"); } else { echo("valid"); } ?>"><?php if($this->_user["user_account_status"] == "valid"){ echo("Disable Account"); } else { echo("Reactivate Account"); } ?></a>
    <?php else: ?>
        <span>N'oubliez pas de valider votre compte ! </span><a href="index.php?p=resendMail">Renvoyer le mail</a>
    <?php endif; ?>
    <a href="index.php?p=deleteAccount">Delete Account</a>
    <br>
    <a href="index.php?p=feed">Feed</a>
    <a href="index.php?p=logout&type=device">Lougout</a>
    <a href="index.php?p=logout&type=allDevice">Lougout all device</a>
</body>
</html>