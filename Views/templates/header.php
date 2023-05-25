<?php

?>
<head>
    <link rel="stylesheet" type="text/css" href="../Views/styles/header.css">
</head>

<header>
    <h1>Uni</h1>
    <div class="inputSearch">
        <label>
            <img src="../Views/assets/icons/searchIcon.svg" alt="Icone de recherche">
            <input type="search" placeholder="Chercher un membre">
        </label>
    </div>
    <nav class="headerNav">
        <a href="#" class="headerCTA">Create</a>
        <img src="../Views/assets/imgs/users/picture/<?= $username ?? "default_picture.jpg" ?>" alt="Image de <?= $username ?? "anonyme" ?>">
    </nav>
</header>
