<?php
require_once ('../Controllers/PageController.php');
$pageController = new \Page\PageController();
if(isset($_POST["searchInput"])) {
    $redirect = "Location: "."http://localhost/projet-rs-hetic/public/index.php?p=search&filter=".$_POST["searchInput"];
    header($redirect);
}

if(isset($_POST["createPage"])) {
    $pageController->createPage($_POST["page_at"], $_POST["name"], $_POST["bio"], $_POST["niche"]);
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
        <button class="headerCTA" id="createCta">Create</button>
        <img class="userPdp" src="../Views/assets/imgs/users/picture/<?="default_picture.jpg"?>" alt="Image de <?= $username ?? "anonyme" ?>">
    </nav>
</header>
<div id="modalContrainer" class="hide">
    <div id="createModal" >
        <h1>Create page Form</h1>
        <form method="post">
            <div>
                <label for="page_at">Enter the page @</label>
                <input type="text" name="page_at" id="page_at" placeholder="@...">
            </div>
            <div>
                <label for="name">Enter the page's name</label>
                <input type="text" name="name" id="name" placeholder="Name...">
            </div>
            <div>
                <label for="bio">Enter the page's bio</label>
                <input type="text" name="bio" id="bio" placeholder="This place is about...">
            </div>
            <div>
                <label for="niche">Select your niche</label>
                <select id="niche" name="niche">
                    <option value="tech">Tech</option>
                    <option value="3d">3D</option>
                    <option value="web">Web</option>
                    <option value="lifestyle">Lifestyle</option>
                    <option value="other">Others</option>
                </select>
            </div>

            <button id="closeModal" class="headerCTA" type="button">Close</button>
            <button id="createPage" class="headerCTA" name="createPage">Create</button>
        </form>
    </div>

</div>

<script>
    document.getElementById("createCta").addEventListener("click", () => {
        document.getElementById("modalContrainer").classList.contains("hide") ?
            document.getElementById("modalContrainer").classList.remove("hide") :
            document.getElementById("modalContrainer").classList.add("hide")
    });

    document.getElementById('closeModal').addEventListener('click', () => {
        document.getElementById("modalContrainer").classList.add("hide");
    })


</script>
