<head>
    <link rel="stylesheet" href="../Views/styles/sideProfile.css">
</head>

<aside>
    <div class="profile">
        <img class ="pp"src="../Views/assets/imgs/users/picture/default_picture.jpg" alt="User profil pic">
        <span>@<?= $username ?><span>
    </div>
    <nav>
        <ul>
            <li><a href="index.php?p=profile&profile_id=<?= $_COOKIE['uniCookieUserID'] ?>">Profil</a></li>
            <li><a href="index.php?p=feed">Feed</a></li>
            <li><a href="index.php?p=friends">Mes Amis</a></li>
            <li><a href="index.php?p=pages">Pages</a></li>
            <li><a href="index.php?p=userOptions">Options</a></li>
            <li><a href="index.php?p=logout&type=device">Déconnexion</a></li>
            <li><a href="index.php?p=logout&type=allDevice">Déconnexion global</a></li>
        </ul>
    </nav>

</aside>