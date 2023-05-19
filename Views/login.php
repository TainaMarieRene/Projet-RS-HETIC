<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniLink | <?= $this->_page; ?></title>
</head>
<body>
    <?php if($this->_method == "POST" && $this->_error): ?>
        <span><?= $this->_error ?></span>
    <?php endif; ?>
    
    <form method="POST">
        <input id="mail" name="mail" type="text" placeholder="Adresse mail" <?php if($this->_method == "POST" && $mail): ?> value="<?= $mail ?>" <?php endif; ?>>
        <input id="password" name="password" type="password" placeholder="Mot de pass">
        <input type="submit" value="Connexion">
    </form>
    <span>Pas encore de compte ? </span><a href="index.php?p=register">Inscrivez-vous !</a>
</body>
</html>