<head>
    <link rel="stylesheet" href="../Views/styles/sideProfile.css">
</head>

<aside>
    <div class="profile">
        <img class ="pp"src="<?= "https://www.liberation.fr/resizer/4aGj4IanoRaHCqrPJx-tLrl0uYY=/1024x0/filters:format(jpg):quality(70):focal(2395x2721:2405x2731)/cloudfront-eu-central-1.images.arcpublishing.com/liberation/2GMZBJOWNNBNVHMMTL3XJOIV7I.jpg" ?>"
            alt="PP" />
        <span>
            <?= "@Pseudo" ?>
            <span>
    </div>
    <div class="bio">
        <p>
            <?= "bio: Je vis que pour faire plus de papier" ?>
        </p>
    </div>

    <nav>
        <ul>
            <li><a href="index.php?p=profile&profile_id=<?= $_COOKIE['uniCookieUserID'] ?>">Profil</a></li>
            <li><a href="http://">Notifications</a></li>
            <li><a href="http://">Friends</a></li>
            <li><a href="http://">Pages</a></li>
            <li><a href="http://">Groups</a></li>
            <li><a href="index.php?p=userOptions">Options d'utilisateur</a></li>
            <li><a href="index.php?p=logout&type=device">Deconnexion</a></li>
            <li><a href="index.php?p=logout&type=allDevice">Deconnexion global</a></li>
        </ul>
    </nav>

</aside>