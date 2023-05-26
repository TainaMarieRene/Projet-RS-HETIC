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
                        <input name="typeForme" type="hidden" value="post">
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
                    <span><?= count($this->_modelPost->getReactionPosts("post", $post["post_id"])) ?> réactions</span>
                    <button class="reactButton">Réagir</button>
                    <div class="react hide">
                        <ul>
                            <li><a href="index.php?p=react&reaction_type=post&reaction_type_id=<?= $post["post_id"] ?>&reaction_emoji=like">like</a></li>
                            <li><a href="index.php?p=react&reaction_type=post&reaction_type_id=<?= $post["post_id"] ?>&reaction_emoji=celebrate">celebrate</a></li>
                            <li><a href="index.php?p=react&reaction_type=post&reaction_type_id=<?= $post["post_id"] ?>&reaction_emoji=love">love</a></li>
                            <li><a href="index.php?p=react&reaction_type=post&reaction_type_id=<?= $post["post_id"] ?>&reaction_emoji=insightful">insightful</a></li>
                            <li><a href="index.php?p=react&reaction_type=post&reaction_type_id=<?= $post["post_id"] ?>&reaction_emoji=curious">curious</a></li>
                            <li>-----------------------------------------------------</li>
                        </ul>
                        <ul>
                            <?php foreach($this->_modelPost->getReactionPosts("post", $post["post_id"]) as $reaction): ?>
                                <li><?= $reaction["user_username"]?> <?= $reaction["reaction_emoji"] ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                    <span><?= count($this->_modelComment->getCommentPosts($post["post_id"])) ?> commentaires</span>
                    <button class="commentButton">Voir plus...</button>
                    <div class="comment hide">
                        <form method="POST">
                            <input name="commentContent" type="text" placeholder="Ecrire un commentaire...">
                            <input name="postId" type="hidden" value="<?= $post["post_id"] ?>">
                            <input name="typeForme" type="hidden" value="postComment">
                            <input type="submit" value="Envoyer">
                        </form>
                        <ul>
                            <?php foreach($this->_modelComment->getCommentPosts($post["post_id"], NULL) as $comment): ?>
                                <li class="allComment">
                                    <?= $comment["user_username"]?> : <?= $comment["post_comment_content"] ?>
                                        <span><?= count($this->_modelPost->getReactionPosts("comment", $comment["post_comment_id"])) ?> réactions</span>
                                        <button class="reactCommentButton">Réagir</button>
                                        <div class="commentReaction hide">
                                            <ul>
                                                <li><a href="index.php?p=react&reaction_type=comment&reaction_type_id=<?= $comment["post_comment_id"] ?>&reaction_emoji=like">like</a></li>
                                                <li><a href="index.php?p=react&reaction_type=comment&reaction_type_id=<?= $comment["post_comment_id"] ?>&reaction_emoji=celebrate">celebrate</a></li>
                                                <li><a href="index.php?p=react&reaction_type=comment&reaction_type_id=<?= $comment["post_comment_id"] ?>&reaction_emoji=love">love</a></li>
                                                <li><a href="index.php?p=react&reaction_type=comment&reaction_type_id=<?= $comment["post_comment_id"] ?>&reaction_emoji=insightful">insightful</a></li>
                                                <li><a href="index.php?p=react&reaction_type=comment&reaction_type_id=<?= $comment["post_comment_id"] ?>&reaction_emoji=curious">curious</a></li>
                                                <li>-----------------------------------------------------</li>
                                            </ul>
                                            <ul>
                                                <?php foreach($this->_modelPost->getReactionPosts("comment", $comment["post_comment_id"]) as $reaction): ?>
                                                    <li><?= $reaction["user_username"]?> <?= $reaction["reaction_emoji"] ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>

                                        <span><?= count($this->_modelComment->getCommentPosts($post["post_id"], $comment["post_comment_id"])) ?> réponses</span>
                                        <button class="commentCommentButton">Voir plus...</button>
                                        <div class="commentComment hide">
                                            <form method="POST">
                                                <input name="commentCommentContent" type="text" placeholder="Ecrire un commentaire...">
                                                <input name="postId" type="hidden" value="<?= $post["post_id"] ?>">
                                                <input name="commentId" type="hidden" value="<?= $comment["post_comment_id"] ?>">
                                                <input name="typeForme" type="hidden" value="postCommentComment">
                                                <input type="submit" value="Envoyer">
                                            </form>
                                            <ul>
                                                <?php foreach($this->_modelComment->getCommentPosts($post["post_id"], $comment["post_comment_id"]) as $commentComment): ?>
                                                    <li class="allCommentComment">
                                                        <?= $commentComment["user_username"]?> : <?= $commentComment["post_comment_content"] ?>
                                                        <span><?= count($this->_modelPost->getReactionPosts("comment", $commentComment["post_comment_id"])) ?> réactions</span>
                                                        <button class="reactCommentCommentButton">Réagir</button>
                                                        <div class="commentCommentReaction hide">
                                                            <ul>
                                                                <li><a href="index.php?p=react&reaction_type=comment&reaction_type_id=<?= $commentComment["post_comment_id"] ?>&reaction_emoji=like">like</a></li>
                                                                <li><a href="index.php?p=react&reaction_type=comment&reaction_type_id=<?= $commentComment["post_comment_id"] ?>&reaction_emoji=celebrate">celebrate</a></li>
                                                                <li><a href="index.php?p=react&reaction_type=comment&reaction_type_id=<?= $commentComment["post_comment_id"] ?>&reaction_emoji=love">love</a></li>
                                                                <li><a href="index.php?p=react&reaction_type=comment&reaction_type_id=<?= $commentComment["post_comment_id"] ?>&reaction_emoji=insightful">insightful</a></li>
                                                                <li><a href="index.php?p=react&reaction_type=comment&reaction_type_id=<?= $commentComment["post_comment_id"] ?>&reaction_emoji=curious">curious</a></li>
                                                                <li>-----------------------------------------------------</li>
                                                            </ul>
                                                            <ul>
                                                                <?php foreach($this->_modelPost->getReactionPosts("comment", $commentComment["post_comment_id"]) as $reaction): ?>
                                                                    <li><?= $reaction["user_username"]?> <?= $reaction["reaction_emoji"] ?></li>
                                                                <?php endforeach; ?>
                                                            </ul>
                                                        </div>
                                                        <?php if($comment["user_id"] == $_COOKIE['uniCookieUserID']): ?><a href="index.php?p=deleteComment&comment_id=<?= $comment["post_comment_id"] ?>">supprimer</a><?php endif; ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>

                                        <?php if($comment["user_id"] == $_COOKIE['uniCookieUserID']): ?><a href="index.php?p=deleteComment&comment_id=<?= $comment["post_comment_id"] ?>">supprimer</a><?php endif; ?>
                                    </li>
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
            reactPostButton.addEventListener("click", () => {
                showReactPost.classList.toggle("hide")
            })
            const commentPostButton = post.querySelector(".commentButton")
            const showCommentPost = post.querySelector(".comment")
            commentPostButton.addEventListener("click", () => {
                showCommentPost.classList.toggle("hide")
            })

            const comments = post.querySelectorAll(".allComment")
            comments.forEach((comment) => {
                const reactCommentButton = comment.querySelector(".reactCommentButton")
                const showCommentReaction = comment.querySelector(".commentReaction")
                reactCommentButton.addEventListener("click", () => {
                    showCommentReaction.classList.toggle("hide")
                })
                const commentCommentPostButton = comment.querySelector(".commentCommentButton")
                const showCommentCommentPost = comment.querySelector(".commentComment")
                commentCommentPostButton.addEventListener("click", () => {
                    showCommentCommentPost.classList.toggle("hide")
                })
                const commentComments = comment.querySelectorAll(".allCommentComment")
                commentComments.forEach((commentComment) => {
                    const reactCommentCommentButton = commentComment.querySelector(".reactCommentCommentButton")
                    const showCommentCommentReaction = commentComment.querySelector(".commentCommentReaction")
                    reactCommentCommentButton.addEventListener("click", ()=>{
                        showCommentCommentReaction.classList.toggle("hide")
                    })
                })
            })
        })
    </script>
</body>
</html>