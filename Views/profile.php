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
                <a href="index.php?p=feed">Feed</a>
                <?php if((filter_input(INPUT_GET, "profile_id")) == $_COOKIE['uniCookieUserID']): ?>
                    <a href="index.php?p=userOptions">Options d'utilisateur</a>
                <?php endif; ?>
            </div>
            <?php if((filter_input(INPUT_GET, "profile_id")) == $_COOKIE['uniCookieUserID']): ?>
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
            <?php endif; ?>
            <?php foreach ($userPosts as $post): ?>
                <div class="userPost-block" id="post_id_<?= $post["post_id"] ?>">
                    <img src="../Views/assets/imgs/users/picture/<?= $post["profile_picture"]; ?>" alt="photo de profil">
                    <span><?= $post["user_username"] ?></span>
                    <span>Il y a <?= $this->getNewDate($post["post_date"]) ?></span> 
                    <p><?= $post["post_content"] ?></p>
                    <?php if(isset($post["post_img"])):?>
                        <img src="../Views/assets/imgs/users/posts/<?= $post["post_img"] ?>" alt="Image du post de <?= $post["user_username"]?>">
                    <?php endif; ?>
                    <span><?= count($this->_modelPost->getReactionPosts("post", $post["post_id"])) ?> Réactions</span>
                    <button class="reactButton">Réagir</button>
                    <div class="react hide">
                        <ul>
                            <li><a href="index.php?p=react&reaction_type=post&reaction_type_id=<?= $post["post_id"] ?>&reaction_emoji=like">like</a></li>
                            <li><a href="index.php?p=react&reaction_type=post&reaction_type_id=<?= $post["post_id"] ?>&reaction_emoji=celebrate">celebrate</a></li>
                            <li><a href="index.php?p=react&reaction_type=post&reaction_type_id=<?= $post["post_id"] ?>&reaction_emoji=love">love</a></li>
                            <li><a href="index.php?p=react&reaction_type=post&reaction_type_id=<?= $post["post_id"] ?>&reaction_emoji=insightful">insightful</a></li>
                            <li><a href="index.php?p=react&reaction_type=post&reaction_type_id=<?= $post["post_id"] ?>&reaction_emoji=curious">curious</a></li>
                        </ul>
                        <ul>
                            <?php foreach($this->_modelPost->getReactionPosts("post", $post["post_id"]) as $reaction): ?>
                                <span><?= $reaction["user_username"]?> <?= $reaction["reaction_emoji"] ?> </span>
                                <br>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <?php if((filter_input(INPUT_GET, "profile_id")) == $_COOKIE['uniCookieUserID']): ?>
                        <a href="index.php?p=deletePost&post_id=<?= $post["post_id"] ?>">Supprimer le post</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
    </section>
    <script>
        const posts = document.querySelectorAll(".userPost-block")

        posts.forEach((post) => {
            const reactPostButton = post.querySelector(".reactButton")
            const showReactPost = post.querySelector(".react")
            reactPostButton.addEventListener("click", ()=>{
                showReactPost.classList.toggle("hide")
            })
        })
    </script>
</body>
</html>