<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 
<form method="POST" action="creer_groupe.php" enctype="multipart/form-data">
  <label for="group_name">Nom du groupe:</label>
  <input type="text" name="group_name" id="group_name" required><br>
  
  <label for="group_status">Statut du groupe:</label>
  <select name="group_status" id="group_status" required>
    <option value="public">Public</option>
    <option value="prive">Privé</option>
  </select><br>
  
  <label for="group_at">Lieu:</label>
  <input type="text" name="group_at" id="group_at" required><br>
  
  <label for="group_picture">Photo de profil:</label>
  <input type="file" name="group_picture" id="group_picture"><br>
  
  <label for="group_banner">Bannière:</label>
  <input type="file" name="group_banner" id="group_banner"><br>
  
  <label for="group_desc">Description:</label>
  <textarea name="group_desc" id="group_desc" required></textarea><br>
  
  <label for="group_tag">Tags:</label>
  <input type="text" name="group_tag" id="group_tag" placeholder="Séparez les tags par des espaces"><br>
  
  <input type="submit" value="Créer le groupe">
  <form method="POST" action="creer_groupe.php" enctype="multipart/form-data">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $group_name = $_POST['group_name'];
    $group_status = $_POST['group_status'];
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
} else {
    echo "Le groupe n'a pas été créé, merci de recommencer.";
}
?>
