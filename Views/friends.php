<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniLink | <?= $this->_page;?></title>
</head>
<body>
    <h2>Mes Amis</h2>
    <?php foreach ($this->_friends as $friend): ?>
        <h3><?= $friend['user_firstname'] . " " . $friend['user_lastname'] ?></h3>
        <span><?= "@" . $friend['user_username']; ?></span>
        <form action="index.php?p=blockFriend" method="post">
            <input type="hidden" name="user_id2" value="<?= $friend['user_id']; ?>">
            <input type="submit" value="Bloquer">
        </form>
        <form action="index.php?p=deleteFriend" method="post">
            <input type="hidden" name="user_id2" value="<?= $friend['user_id']; ?>">
            <input type="submit" value="Supprimer">
        </form>
    <?php endforeach; ?>

    <h2>Demandes en Attente</h2>
    <?php foreach ($this->_friends_request as $friend_request): ?>
        <h3><?= $friend_request['user_firstname'] . " " . $friend_request['user_lastname'] ?></h3>
        <span><?= "@" . $friend_request['user_username']; ?></span>
        <form action="index.php?p=blockFriend" method="post">
            <input type="hidden" name="user_id2" value="<?= $friend_request['user_id']; ?>">
            <input type="submit" value="Bloquer">
        </form>
        <form action="index.php?p=deleteFriend" method="post">
            <input type="hidden" name="user_id2" value="<?= $friend_request['user_id']; ?>">
            <input type="submit" value="Supprimer">
        </form>
    <?php endforeach; ?>

    <h2>Demandes Reçues</h2>
    <?php foreach ($this->_friends_requesting as $friend_requesting): ?>
        <h3><?= $friend_requesting['user_firstname'] . " " . $friend_requesting['user_lastname'] ?></h3>
        <span><?= "@" . $friend_requesting['user_username']; ?></span>
        <form action="index.php?p=acceptFriend" method="post">
            <input type="hidden" name="user_id2" value="<?= $friend_requesting['user_id']; ?>">
            <input type="submit" value="Accepter">
        </form>
        <form action="index.php?p=blockFriend" method="post">
            <input type="hidden" name="user_id2" value="<?= $friend_requesting['user_id']; ?>">
            <input type="submit" value="Bloquer">
        </form>
        <form action="index.php?p=deleteFriend" method="post">
            <input type="hidden" name="user_id2" value="<?= $friend_requesting['user_id']; ?>">
            <input type="submit" value="Supprimer">
        </form>
    <?php endforeach; ?>

    <h2>Utilisateurs bloqués</h2>
    <?php foreach ($this->_blocked as $blocked): ?>
        <h3><?= $blocked['user_firstname'] . " " . $blocked['user_lastname'] ?></h3>
        <span><?= "@" . $blocked['user_username']; ?></span>
        <form action="index.php?p=unblockFriend" method="post">
            <input type="hidden" name="user_id2" value="<?= $blocked['user_id']; ?>">
            <input type="submit" value="Débloquer">
        </form>
        <form action="index.php?p=deleteFriend" method="post">
            <input type="hidden" name="user_id2" value="<?= $blocked['user_id']; ?>">
            <input type="submit" value="Supprimer">
        </form>
    <?php endforeach; ?>

</body>
</html>