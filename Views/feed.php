<?php 
//require_once("../controllers/functions.php");
// $post=getUserPoser(1);
// var_dump($post);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed - <?="TON NOM"?></title>
</head>
<body>
    <?php require_once("./templates/side_profile.php")?>
    <article>
        <img src="<?= '' ?>" alt="friend_pp" />
        <span><?="friend_pseudo"?><span> 
        <p><?="post_date"?></p>
        <p><?="post_content"?></p>
        <img src="" alt="coeur">
        <img src="" alt="commentary">
    </article>
</body>
</html>