<?php
if(isset($_POST["searchInput"])) {
    $redirect = "Location: "."http://localhost/projet-rs-hetic/public/index.php?p=search&filter=".$_POST["searchInput"];
    header($redirect);
}


?>
<head>
    <link rel="stylesheet" type="text/css" href="../Views/styles/header.css">
</head>

<header>
    <a href="http://localhost/projet-rs-hetic/public/index.php?p=feed"><h1>Uni</h1></a>
    <form class="inputSearch" method="post">
        <label>
            <img src="../Views/assets/icons/searchIcon.svg" alt="Icone de recherche">
        </label>
        <input type="search" name="searchInput" placeholder="Chercher un membre ou une page">
    </form>
    <nav class="headerNav">
        <a href="#" class="headerCTA">Create</a>
        <img class="userPdp" src="../Views/assets/imgs/users/picture/<?="default_picture.jpg"?>" alt="Image de <?= $username ?? "anonyme" ?>">
    </nav>
</header>
