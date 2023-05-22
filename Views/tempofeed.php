<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UniLink | <?= $this->_page; ?></title>
</head>
<body>
    <?php if(preg_match("`^(valid)$`", filter_input(INPUT_GET, "success"))): ?>
        <span>Mail validé</span>
    <?php elseif(preg_match("`^(error)$`", filter_input(INPUT_GET, "success"))): ?>
        <span>Erreur durant la validation du mail, veuillez ressayer</span>
    <?php endif; ?>
    <h1>FEED</h1>
    <p>Feed temporaire pour réaliser des tests</p>
    <a href="index.php?p=userOptions">Options d'utilisateur</a>
    <a href="index.php?p=logout&type=device">Lougout</a>
    <a href="index.php?p=logout&type=allDevice">Lougout all device</a>
</body>
</html>