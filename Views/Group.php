<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/group.css">
</head>
<body>
    <form method="POST" action="creer_groupe.php" enctype="multipart/form-data">
    <div>
        <label for="group_name" class="label">Nom du groupe</label>
        <div class="input-wrapper">
            <input type="text" name="group_name" id="group_name" class="input" placeholder="..." required>
        </div>
    </div>

    <div>
        <label for="status" class="label">Statut</label>
        <select id="status" name="status" class="input select-input" required>
            <option value="prive" selected>Privé</option>
            <option value="public">Public</option>
        </select>
      </div>

    <div>
        <label for="group_at" class="label">Lieu</label>
        <div class="input-wrapper">
            <input type="text" name="group_at" id="group_at" class="input" placeholder="..." required>
        </div>
    </div>

    <div>
        <label for="group_picture" class="label">Photo</label>
        <div class="flex-container">
        <svg class="svg-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
        </svg>
        <input type="file" id="group_picture" name="group_picture" class="file-input" />
        </div>
    </div>

    <div>
        <label for="group_banner" class="label">Bannière</label>
        <div class="flex-container">
        <svg class="svg-icon" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
        </svg>
        <input type="file" id="group_banner" name="group_banner" class="file-input" />
        </div>
    </div>

    <div>
        <label for="group_desc" class="label">Description</label>
        <div class="input-wrapper">
            <input type="text" name="group_desc" id="group_desc" class="input" placeholder="..." required>
        </div>
    </div>
    
    <div>
        <label for="group_tag" class="label">Tags</label>
        <div class="input-wrapper">
            <input type="text" name="group_tag" id="group_tag" class="input" placeholder="..." required>
        </div>
    </div>
    
    <button type="submit" class="button">Créé le groupe</button>
    </form>
</body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_name = $_POST['group_name'];
    $group_status = $_POST['status'];
    $group_at = $_POST['group_at'];
    $group_picture = $_FILES['group_picture']['name'];
    $group_banner = $_FILES['group_banner']['name'];
    $group_desc = $_POST['group_desc'];
    $group_tag = $_POST['group_tag'];
    $group_creator = 1; 
    
    $messageController = new MessageController();
    $group_id = $messageController->creerGroupeConversation($group_creator, $group_name, $group_status, $group_picture, $group_banner, $group_desc, $group_tag, $group_at);
    
    $target_dir = "uploads/";
    $target_file_picture = $target_dir . basename($_FILES['group_picture']['name']);
    $target_file_banner = $target_dir . basename($_FILES['group_banner']['name']);
    move_uploaded_file($_FILES['group_picture']['tmp_name'], $target_file_picture);
    move_uploaded_file($_FILES['group_banner']['tmp_name'], $target_file_banner);
    
    echo "Le groupe a été créé avec succès!";
    header("Location: groupe.php?id=$group_id");
    exit();
} 
?>

