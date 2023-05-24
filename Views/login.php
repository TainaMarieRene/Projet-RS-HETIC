<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniLink | <?= $this->_page; ?></title>
    <link rel="stylesheet" href="../Views/styles/style.css">
    <link rel="stylesheet" href="../Views/styles/auth.css">
</head>
<body class="login">
    <div class="authcard <?php if($this->_method == "POST" && $this->_error){ echo("autherror"); } ?>">
        <?php if($this->_method == "POST" && $this->_error): ?>
            <div class="error" ><?= $this->_error ?></div>
        <?php endif; ?>
        <form method="POST">
            <div class="input title_form">
                <h1><img src="../Views/assets/imgs/website/unilink_logo.svg" alt="UniLink Logo" class="logo"></h1>
                <h2>Connexion :</h2>
            </div>
            <input id="mail" name="mail" type="text" placeholder="exemple@mail.com" <?php if($this->_method == "POST" && $mail): ?> value="<?= $mail ?>" <?php endif; ?>>
            <input id="password" name="password" type="password" placeholder="Password">
            <input type="submit" value="Connexion" class="sendAuth">
        </form>
        <span class="ask">Pas encore de compte ?&nbsp; <a href="index.php?p=register">Inscrivez-vous !</a></span>
    </div>
</body>
</html>