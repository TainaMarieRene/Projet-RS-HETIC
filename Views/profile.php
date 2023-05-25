<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniLink | <?= $user["user_username"]; ?>'s Profile</title>
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
                <?php if($this->_method == "POST" && $this->_error): ?>
                    <div class="error" ><?= $this->_error ?></div>
                <?php endif; ?>
                <form class="postCta" method="POST" enctype="multipart/form-data">
                    <!-- <label for="postContent" class="hiddenLabel">Create Post Content Label</label> -->
                    <input type="text" name="postContent" id="postContent" placeholder='Quoi de neuf ?'>
                    <label for="postImg" class="mediaInput"><img alt="Media Icon" src="../Views/assets/icons/media.svg"></label>
                    <input type="file" name="postImg" id="postImg">
                    <input type="submit" value="Ajouter">
                </form>
            </div>
            <?php foreach ($userPosts as $post): ?>
                <div class="userPost-block">
                    <span><?= $post["post_date"] ?></span>
                    <p><?= $post["post_content"] ?></p>
                    <?php if(isset($post["post_img"])):?>
                        <img src="../Views/assets/imgs/users/posts/<?= $post["post_img"] ?>" alt="Image du post de <?= $user["user_username"]?>">
                    <?php endif; ?>
                    <a href="index.php?p=deletePost&post_id=<?= $post["post_id"] ?>">Supprimer le post</a>
                </div>
            <?php endforeach; ?>
    </section>
</body>
</html>