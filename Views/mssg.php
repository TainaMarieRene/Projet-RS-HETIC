<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles/mssg.css">
    <script src="./mssg.js" defer></script>
    <title>Document</title>
</head>
<body>
    <div class="nav-bar">
         <img src="../website/unilink_logo.svg" alt="Logo"/>
        <div class="search-bar"><button><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="M15.5 14h-.79l-.28-.27A6.471 6.471 0 0 0 16 9.5A6.5 6.5 0 1 0 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5S14 7.01 14 9.5S11.99 14 9.5 14z"/></svg></button><input class="search-text" type="text" placeholder="Chercher un membre"></div>
    <div class="section">
        <div class="btn">
          <a href="Group.php">Créer un groupe</a>
        </div>
        <div class="profil">
          <a href="./Views/templates/profile.php"><img src="https://images.unsplash.com/photo-1684936193634-655c7ff53b20?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80" alt="avatar"></a>
        </div>
</div>

    </div>

    </div>

    <div class="section">
        <div class="sidebar">
            <div>
                <h3>Conversations</h3>
                <div class="conversation">
                    <img src="https://images.unsplash.com/photo-1684936193634-655c7ff53b20?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80" alt="avatar">
                    <div class="resume">
                        <span class="name">Test</span>
                        <span>dzefgrnh</span>
                    </div>
                </div>
            </div>

            <div>
                <h3>Groupes</h3>
                <div class="conversation">
                    <img src="https://images.unsplash.com/photo-1684936193634-655c7ff53b20?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80" alt="avatar">
                    <div class="resume">
                        <span class="name">Test</span>
                        <span>dzefgrnh</span>
                    </div>
                </div>
                
            </div>
        
        </div>

        <div class="page">
            <div class="container">

                <div class="messages">
                    <div class="message">
                        <img src="https://images.unsplash.com/photo-1684936193634-655c7ff53b20?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80" alt="avatar">
                        <div class="text-other">
                            Lorem ipsum dolor sit amet consectetur adipisicing elit. Laudantium facilis soluta, molestias maxime nihil voluptates culpa ex obcaecati ab quidem commodi. Voluptas ipsam, nulla placeat exercitationem aspernatur aliquam numquam ut?
                        </div>
                    </div>

                    <div class="message me">
                        <div class="text">
                           Lorem ipsum dolor sit amet consectetur adipisicing elit. Nobis alias perferendis est quidem inventore, magni veniam atque ab corporis at saepe doloribus ullam sapiente non? Animi minus doloremque laborum. Ducimus! 
                        </div>
                        <img src="https://images.unsplash.com/photo-1684936193634-655c7ff53b20?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=987&q=80" alt="avatar">
                    </div>
                </div>
                
                <div class="sender">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="icons">
                            <div class="input-icon">
                                <label for="file-upload">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M19 5v14H5V5h14m0-2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-4.86 8.86l-3 3.87L9 13.14L6 17h12l-3.86-5.14z"/></svg>                                </label>
                                <input id="file-upload" type="file" name="message_img" style="display: none;">
                            </div>
                            <div class="input-icon">
                                <label for="file-upload">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="m14.12 4l1.83 2H20v12H4V6h4.05l1.83-2h4.24M15 2H9L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2zm-3 7c1.65 0 3 1.35 3 3s-1.35 3-3 3s-3-1.35-3-3s1.35-3 3-3m0-2c-2.76 0-5 2.24-5 5s2.24 5 5 5s5-2.24 5-5s-2.24-5-5-5z"/></svg>
                                </label>
                                <input id="file-upload" type="file" name="message_img" style="display: none;">
                            </div>
                            <div class="input-icon">
                                <label for="file-upload">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M13 7h-2v4H7v2h4v4h2v-4h4v-2h-4V7zm-1-5C6.49 2 2 6.49 2 12s4.49 10 10 10s10-4.49 10-10S17.51 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8s8 3.59 8 8s-3.59 8-8 8z"/></svg>
                                </label>
                                <input id="file-upload" type="file" name="message_img" style="display: none;">
                            </div>
                            
                        </div>
                        <div class="send">
                            
                                <input type="hidden" name="conversation_id" value="1"> 
                                <input type="hidden" name="user_id" value="1"> 
                                <input name="message_content" placeholder="Contenu du message">
                                <button type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path fill="currentColor" d="m17.27 6.73l-4.24 10.13l-1.32-3.42l-.32-.83l-.82-.32l-3.43-1.33l10.13-4.23M21 3L3 10.53v.98l6.84 2.65L12.48 21h.98L21 3z"/></svg></button>
                        </div>
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"><path fill="currentColor" d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8s8 3.58 8 8s-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8S14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8S7 8.67 7 9.5S7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/></svg>                    </form>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>

<?php
    require_once 'MessageController.php';

    $messageController = new MessageController();

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

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
