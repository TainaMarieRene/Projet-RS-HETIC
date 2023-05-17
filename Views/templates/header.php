<?php
$username = ""

?>
<head>
    <link rel="stylesheet" type="text/css" href="./styles/header.css">
</head>

<header>
    <h1>Uni</h1>
    <div class="inputSearch">
        <label>
            <img src="./assets/icons/searchIcon.svg">
            <input type="search" placeholder="Chercher un membre">
        </label>
    </div>
    <nav class="headerNav">
        <a href="#" class="headerCTA">Create</a>
        <img src="../assets/imgs/users/picture/<?= $username ?>">
    </nav>
</header>
