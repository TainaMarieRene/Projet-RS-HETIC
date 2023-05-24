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
    <body class="register">
        <div class="authcard <?php if($this->_method == "POST" && $this->_error){ echo("autherror"); } ?>">
            <?php if($this->_method == "POST" && $this->_error): ?>
                <div class="error" ><?= $this->_error ?></div>
            <?php endif; ?>
            <form method="POST">
            <div class="input title_form">
                <h1><img src="../Views/assets/imgs/website/unilink_logo.svg" alt="UniLink Logo" class="logo"></h1>
                <h2>Inscription :</h2>
            </div>
                <input id="firstname" name="firstname" type="text" placeholder="Prénom" <?php if($this->_method == "POST" && $firstname): ?> value="<?= $firstname ?>" <?php endif; ?>>
                <input id="lastname" name="lastname" type="text" placeholder="Nom" <?php if($this->_method == "POST" && $lastname): ?> value="<?= $lastname ?>" <?php endif; ?>>
                <div class="input">
                    <label for="birthdate">Date de naissance :</label>
                    <input id="birthdate" name="birthdate" type="date" <?php if($this->_method == "POST" && $birthdate): ?> value="<?= $birthdate ?>" <?php endif; ?>>
                </div>
                <input id="username" name="username" type="text" placeholder="Identifiant" <?php if($this->_method == "POST" && $username): ?> value="<?= $username ?>" <?php endif; ?>>
                <input id="mail" name="mail" type="text" placeholder="Adresse mail" <?php if($this->_method == "POST" && $mail): ?> value="<?= $mail ?>" <?php endif; ?>>
                <input id="password" name="password" type="password" placeholder="Mot de passe">
                <input id="password2" name="password2" type="password" placeholder="Valider votre mot de passe">
                <input type="submit" value="Inscription" class="sendAuth">
            </form>
            <span class="ask askcesure">Déjà un compte ?&nbsp; <a href="index.php">Connectez-vous !</a></span>
        </div>
    </body>
</html>