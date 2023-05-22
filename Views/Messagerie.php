<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Messagerie</title>
</head>
<body>
  <h1>Messagerie</h1>

  <h2>Envoyer un message</h2>

  <form method="POST" enctype="multipart/form-data">
    <input type="hidden" name="conversation_id" value="1"> 
    <input type="hidden" name="user_id" value="1"> 
    <textarea name="message_content" rows="4" cols="50" placeholder="Contenu du message"></textarea>
    <input type="file" name="message_img">
    <input type="submit" name="envoyer" value="Envoyer">
  </form>

</body>
</html>

<?php
    require_once 'MessageController.php';

    $messageController = new MessageController();

    if (isset($_POST['envoyer'])) {
      $conversation_id = $_POST['conversation_id'];
      $user_id = $_POST['user_id'];
      $message_content = $_POST['message_content'];
      $message_img = $_FILES['message_img']['name'];

      $target_dir = "uploads/";
      $target_file = $target_dir . basename($_FILES['message_img']['name']);
      move_uploaded_file($_FILES['message_img']['tmp_name'], $target_file);

      
      $messageController->envoyerMessage($conversation_id, $user_id, $message_content, $message_img);
    }

    
    $conversation_id = 1; 
    $messages = $messageController->recevoirMessages($conversation_id);

    foreach ($messages as $message) {
      $message_id = $message['message_id'];
      $message_content = $message['message_content'];
      $message_date = $message['message_date'];
      $message_imgs = $messageController->getMessageImages($message_id);
      $reactions = $messageController->getMessageReactions($message_id);

      echo "<div>";
      echo "<p>Message ID: $message_id</p>";
      echo "<p>Contenu: $message_content</p>";
      echo "<p>Date: $message_date</p>";

      if (!empty($message_imgs)) {
        foreach ($message_imgs as $message_img) {
          echo "<img src='uploads/$message_img' alt='Image reçue'><br>";
        }
      }

      echo "<p>Réactions:</p>";

      foreach ($reactions as $reaction) {
        echo "<span>$reaction</span>";
      }

      echo "</div>";

      echo "<hr>";
    }
  ?>