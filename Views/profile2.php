<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniLink | <?= $this->_page; ?></title>
    <link rel="stylesheet" href="../Views/styles/style.css">
    <link rel="stylesheet" href="../Views/styles/profile.css">
    <link rel="stylesheet" type="text/css" href="../Views/styles/feed.css">
</head>
<body class="login">
    <section>
        <img src="../Views/assets/imgs/users/banner/<?= $profile["profile_banner"]; ?>" alt="bannière">
            <div class="profile-block">
                <img src="../Views/assets/imgs/users/picture/<?= $profile["profile_picture"]; ?>" alt="photo de profil" id="picture">
                <span>
                    <?= $user["user_firstname"]?>
                </span>
                <span>
                    <?= $user["user_lastname"]?>
                </span>
                <span>
                    <?= $user["user_username"]?>
                </span>
                <span>
                    <?= $profile["profile_bio"]; ?>
                </span>
                <span>
                    <?= $profile["profile_location"]; ?>
                </span>
                <span>
                    <?= $profile["profile_activity"]; ?>
                </span>
            </div>
            <div class="create-post">
                <form class="postCta" method="POST">
                    <label for="postContent" class="hiddenLabel">Create Post Content Label</label>
                    <input type="text" name="postContent" id="postContent" placeholder='Quoi de neuf ?'>
                    <label for="inputImage" class="mediaInput"><img alt="Media Icon" src="assets/icons/media.svg"></label>
                    <input type="file" name="inputImage" id="inputImage">
                    <input type="submit" value="Ajouter">
                </form>
            </div>
            <?php foreach ($userPosts as $post): ?>
                <div class="userPost-block">
                    <span><?=$post["post_date"]?></span>
                    <p><?=$post["post_content"]?></p>
                </div>
            <?php endforeach; ?>
    </section>
</body>
</html>