<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
    <body>
        <form method="POST">
            <input type="text" placeholder="Prénom">
            <input type="text" placeholder="Nom">
            <label for="birthdate">Date de naissance :</label>
            <input id="birthdate" type="date">
            <input type="text" placeholder="Identifiant">
            <input type="text" placeholder="Adresse mail">
            <input type="password" placeholder="Mot de passe">
            <input type="password" placeholder="Valider votre mot de passe">
            <input type="submit" value="Connexion">
        </form>
        
        <span>Déjà un compte ? </span><a href="index.php?p=login">Connectez-vous !</a>
    </body>
</html>