<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniLink | <?= $this->_page; ?></title>
</head>
    <body>
        <!-- TO DO : Préciser les erreurs de l'user suivant les champs -->
        <?php if($this->_method == "POST" && (!$firstname || !$lastname || !$birthdate || !$username || !$mail || !$password || !$password2)): ?>
            <span>Merci de remplir correctement les champs</span>
        <?php endif; ?>

        <form method="POST">
            <input id="firstname" name="firstname" type="text" placeholder="Prénom" <?php if($this->_method == "POST" && $firstname): ?> value="<?= $firstname ?>" <?php endif; ?>>
            <input id="lastname" name="lastname" type="text" placeholder="Nom" <?php if($this->_method == "POST" && $lastname): ?> value="<?= $lastname ?>" <?php endif; ?>>
            <label for="birthdate">Date de naissance :</label>
            <input id="birthdate" name="birthdate" type="date" <?php if($this->_method == "POST" && $birthdate): ?> value="<?= $birthdate ?>" <?php endif; ?>>
            <input id="username" name="username" type="text" placeholder="Identifiant" <?php if($this->_method == "POST" && $username): ?> value="<?= $username ?>" <?php endif; ?>>
            <input id="mail" name="mail" type="text" placeholder="Adresse mail" <?php if($this->_method == "POST" && $mail): ?> value="<?= $mail ?>" <?php endif; ?>>
            <input id="password" name="password" type="password" placeholder="Mot de passe">
            <input id="password2" name="password2" type="password" placeholder="Valider votre mot de passe">
            <input type="submit" value="Inscription">
        </form>
        
        <span>Déjà un compte ? </span><a href="index.php?p=login">Connectez-vous !</a>
    </body>
</html>