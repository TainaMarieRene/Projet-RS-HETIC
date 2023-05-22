<?php

class MessageController {
  
  public function envoyerMessage($conversation_id, $user_id, $message_content, $message_img = null) {
    $messageId = $this->insertMessage($conversation_id, $user_id, $message_content);
    
    if ($message_img != null) {
      $this->insertMessageImage($messageId, $message_img);
    }
  }
  
  public function recevoirMessages($conversation_id) {
    $messages = $this->getConversationMessages($conversation_id);
    
    foreach ($messages as $message) {
      $message_id = $message['message_id'];
      $message_content = $message['message_content'];
      $message_date = $message['message_date'];
      
      $message_imgs = $this->getMessageImages($message_id);
      
      echo "Message ID: $message_id<br>";
      echo "Contenu: $message_content<br>";
      echo "Date: $message_date<br>";
      
      if (!empty($message_imgs)) {
        foreach ($message_imgs as $message_img) {
          echo "<img src='$message_img' alt='Image reçue'><br>";
        }
      }
    } 
  }
  
  public function reagirAuMessage($message_id, $user_id, $reaction_emoji) {
    $this->insertReaction($message_id, $user_id, $reaction_emoji);
  }
  
  public function supprimerMessage($message_id) {
    $this->deleteMessage($message_id);
    $this->deleteMessageReactions($message_id);
    $this->deleteMessageImages($message_id);
  }
  
  private function insertMessage($conversation_id, $user_id, $message_content) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('INSERT INTO messages (conversation_id, user_id, message_content, message_date) VALUES (?, ?, ?, NOW())');
    $stmt->execute([$conversation_id, $user_id, $message_content]);
    
    return $pdo->lastInsertId();
  }
  
  private function insertMessageImage($message_id, $message_img) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('INSERT INTO message_imgs (message_id, message_img) VALUES (?, ?)');
    $stmt->execute([$message_id, $message_img]);
  }
  
  private function getConversationMessages($conversation_id) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('SELECT * FROM messages WHERE conversation_id = ?');
    $stmt->execute([$conversation_id]);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
  }
  
  private function getMessageImages($message_id) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('SELECT message_img FROM message_imgs WHERE message_id = ?');
    $stmt->execute([$message_id]);
    
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
  }
  
  private function getMessageReactions($message_id) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('SELECT reaction_emoji FROM reactions WHERE reaction_type = "message" AND reaction_type_id = ?');
    $stmt->execute([$message_id]);
    
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
  }
  
  private function insertReaction($message_id, $user_id, $reaction_emoji) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('INSERT INTO reactions (reaction_type, reaction_type_id, user_id, reaction_emoji) VALUES (?, ?, ?, ?)');
    $stmt->execute(['message', $message_id, $user_id, $reaction_emoji]);
  }
  
  private function deleteMessage($message_id) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('DELETE FROM messages WHERE message_id = ?');
    $stmt->execute([$message_id]);
  }
  
  private function deleteMessageReactions($message_id) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('DELETE FROM reactions WHERE reaction_type = "message" AND reaction_type_id = ?');
    $stmt->execute([$message_id]);
  }
  
  private function deleteMessageImages($message_id) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('DELETE FROM message_imgs WHERE message_id = ?');
    $stmt->execute([$message_id]);
  }

  public function creerGroupeConversation($user_id, $group_name, $group_status, $group_picture, $group_banner, $group_desc, $group_tag, $group_at) {
    $group_id = $this->insertGroup($group_name, $group_status, $group_picture, $group_banner, $group_desc, $group_tag, $group_at);
    
    $this->ajouterMembreGroupe($group_id, $user_id, 'Créateur du groupe');
    $this->ajouterMembreGroupe($group_id, $user_id, 'Admin');
  }
  
  private function insertGroup($group_name, $group_status, $group_picture, $group_banner, $group_desc, $group_tag, $group_location) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('INSERT INTO groups (group_name, group_status, group_creator, group_picture, group_banner, group_desc, group_tag, group_location, group_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())');
    $stmt->execute([$group_name, $group_status, $group_creator, $group_picture, $group_banner, $group_desc, $group_tag, $group_location]);
    
    return $pdo->lastInsertId();
  }
  
  private function ajouterMembreGroupe($group_id, $user_id, $member_type) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('INSERT INTO members (member_type, member_type_id, user_id) VALUES (?, ?, ?)');
    $stmt->execute([$member_type, $group_id, $user_id]);
  }
  
  public function demanderIntegrerGroupe($group_id, $user_id) {
    $this->ajouterMembreGroupe($group_id, $user_id, 'Member');
  }
  
  public function accepterDemandeGroupe($group_id, $user_id) {
    $this->modifierStatutMembreGroupe($group_id, $user_id, 'Member', 'Accepted');
  }
  
  public function refuserDemandeGroupe($group_id, $user_id) {
    $this->supprimerMembreGroupe($member_type, $group_id, $user_id);
  }
  
  private function modifierStatutMembreGroupe($group_id, $user_id, $member_type, $status) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('UPDATE members SET member_status = ? WHERE member_type = ? AND member_type_id = ? AND user_id = ?');
    $stmt->execute([$status, $member_type, $group_id, $user_id]);
  }
  
  private function supprimerMembreGroupe($group_id, $user_id) {
    $pdo = new PDO('mysql:host=localhost;dbname=unilink', 'root', '');
    $stmt = $pdo->prepare('DELETE FROM members WHERE member_type = ? AND member_type_id = ? AND user_id = ?');
    $stmt->execute(['Member', $group_id, $user_id]);
  }
}

?>






