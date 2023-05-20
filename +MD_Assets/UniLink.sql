-- MySQL dump 10.13  Distrib 5.7.34, for osx11.0 (x86_64)
--
-- Host: localhost    Database: UniLink
-- ------------------------------------------------------
-- Server version	5.7.34

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `authentifications`
--

DROP TABLE IF EXISTS `authentifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `authentifications` (
  `authentification_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_token` varchar(255) NOT NULL,
  `user_token_start` datetime NOT NULL,
  `user_token_end` datetime NOT NULL,
  PRIMARY KEY (`authentification_id`),
  UNIQUE KEY `user_username` (`user_username`),
  UNIQUE KEY `user_token` (`user_token`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `authentifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `authentifications_ibfk_2` FOREIGN KEY (`user_username`) REFERENCES `users` (`user_username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `authentifications`
--

LOCK TABLES `authentifications` WRITE;
/*!40000 ALTER TABLE `authentifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `authentifications` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conversations`
--

DROP TABLE IF EXISTS `conversations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conversations` (
  `conversation_id` int(11) NOT NULL AUTO_INCREMENT,
  `conversation_name` varchar(255) NOT NULL,
  `conversation_picture` varchar(255) NOT NULL,
  PRIMARY KEY (`conversation_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conversations`
--

LOCK TABLES `conversations` WRITE;
/*!40000 ALTER TABLE `conversations` DISABLE KEYS */;
/*!40000 ALTER TABLE `conversations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `conversations_members`
--

DROP TABLE IF EXISTS `conversations_members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `conversations_members` (
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`conversation_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `conversations_members_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`conversation_id`),
  CONSTRAINT `conversations_members_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `conversations_members`
--

LOCK TABLES `conversations_members` WRITE;
/*!40000 ALTER TABLE `conversations_members` DISABLE KEYS */;
/*!40000 ALTER TABLE `conversations_members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `friends`
--

DROP TABLE IF EXISTS `friends`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `friends` (
  `user_id1` int(11) NOT NULL,
  `user_id2` int(11) NOT NULL,
  `user_relation` enum('waiting','blocked','friend') NOT NULL DEFAULT 'waiting',
  PRIMARY KEY (`user_id1`,`user_id2`),
  KEY `user_id2` (`user_id2`),
  CONSTRAINT `friends_ibfk_1` FOREIGN KEY (`user_id1`) REFERENCES `users` (`user_id`),
  CONSTRAINT `friends_ibfk_2` FOREIGN KEY (`user_id2`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `friends`
--

LOCK TABLES `friends` WRITE;
/*!40000 ALTER TABLE `friends` DISABLE KEYS */;
/*!40000 ALTER TABLE `friends` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `groups`
--

DROP TABLE IF EXISTS `groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `groups` (
  `group_id` int(11) NOT NULL AUTO_INCREMENT,
  `group_status` tinyint(1) NOT NULL DEFAULT '0',
  `group_creator` int(11) NOT NULL,
  `group_at` varchar(255) NOT NULL,
  `group_name` varchar(255) NOT NULL,
  `group_picture` varchar(255) DEFAULT NULL,
  `group_banner` varchar(255) DEFAULT NULL,
  `group_desc` varchar(255) DEFAULT NULL,
  `group_tag` set('tech','web','design','3D') DEFAULT NULL,
  `group_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`group_id`),
  UNIQUE KEY `group_at` (`group_at`),
  KEY `group_creator` (`group_creator`),
  CONSTRAINT `groups_ibfk_1` FOREIGN KEY (`group_creator`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `groups`
--

LOCK TABLES `groups` WRITE;
/*!40000 ALTER TABLE `groups` DISABLE KEYS */;
/*!40000 ALTER TABLE `groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members`
--

DROP TABLE IF EXISTS `members`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members` (
  `member_id` int(11) NOT NULL AUTO_INCREMENT,
  `member_type` enum('group','page') NOT NULL,
  `member_type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  PRIMARY KEY (`member_id`),
  UNIQUE KEY `member_unique` (`user_id`,`member_type`,`member_type_id`),
  CONSTRAINT `members_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members`
--

LOCK TABLES `members` WRITE;
/*!40000 ALTER TABLE `members` DISABLE KEYS */;
/*!40000 ALTER TABLE `members` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members_groups_extra`
--

DROP TABLE IF EXISTS `members_groups_extra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_groups_extra` (
  `member_id` int(11) NOT NULL,
  `member_group_request` enum('waiting','blocked','accept') NOT NULL DEFAULT 'waiting',
  `member_group_role` enum('admin','member','creator') NOT NULL DEFAULT 'member',
  PRIMARY KEY (`member_id`),
  CONSTRAINT `members_groups_extra_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members_groups_extra`
--

LOCK TABLES `members_groups_extra` WRITE;
/*!40000 ALTER TABLE `members_groups_extra` DISABLE KEYS */;
/*!40000 ALTER TABLE `members_groups_extra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `members_pages_extra`
--

DROP TABLE IF EXISTS `members_pages_extra`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `members_pages_extra` (
  `member_id` int(11) NOT NULL,
  `member_page_role` enum('follower','admin') NOT NULL DEFAULT 'follower',
  PRIMARY KEY (`member_id`),
  CONSTRAINT `members_pages_extra_ibfk_1` FOREIGN KEY (`member_id`) REFERENCES `members` (`member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `members_pages_extra`
--

LOCK TABLES `members_pages_extra` WRITE;
/*!40000 ALTER TABLE `members_pages_extra` DISABLE KEYS */;
/*!40000 ALTER TABLE `members_pages_extra` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages`
--

DROP TABLE IF EXISTS `messages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL AUTO_INCREMENT,
  `conversation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `message_parent_id` int(11) DEFAULT NULL,
  `message_content` text NOT NULL,
  `message_status` enum('send','see') NOT NULL DEFAULT 'send',
  `message_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`message_id`),
  KEY `conversation_id` (`conversation_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`conversation_id`) REFERENCES `conversations` (`conversation_id`),
  CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages`
--

LOCK TABLES `messages` WRITE;
/*!40000 ALTER TABLE `messages` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `messages_imgs`
--

DROP TABLE IF EXISTS `messages_imgs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `messages_imgs` (
  `message_id` int(11) NOT NULL,
  `message_img` varchar(255) NOT NULL,
  PRIMARY KEY (`message_id`,`message_img`),
  CONSTRAINT `messages_imgs_ibfk_1` FOREIGN KEY (`message_id`) REFERENCES `messages` (`message_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `messages_imgs`
--

LOCK TABLES `messages_imgs` WRITE;
/*!40000 ALTER TABLE `messages_imgs` DISABLE KEYS */;
/*!40000 ALTER TABLE `messages_imgs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pages`
--

DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `page_id` int(11) NOT NULL AUTO_INCREMENT,
  `page_creator` int(11) NOT NULL,
  `page_at` varchar(255) NOT NULL,
  `page_name` varchar(255) NOT NULL,
  `page_picture` varchar(255) DEFAULT NULL,
  `page_banner` varchar(255) DEFAULT NULL,
  `page_desc` varchar(255) DEFAULT NULL,
  `page_tag` set('tech','web','design','3D') DEFAULT NULL,
  `page_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `page_certification` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`page_id`),
  UNIQUE KEY `page_at` (`page_at`),
  KEY `page_creator` (`page_creator`),
  CONSTRAINT `pages_ibfk_1` FOREIGN KEY (`page_creator`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pages`
--

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts` (
  `post_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `post_type` enum('group','page','profile') NOT NULL,
  `post_type_id` int(11) NOT NULL,
  `post_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_content` text NOT NULL,
  PRIMARY KEY (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts`
--

LOCK TABLES `posts` WRITE;
/*!40000 ALTER TABLE `posts` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts_comments`
--

DROP TABLE IF EXISTS `posts_comments`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts_comments` (
  `post_comment_id` int(11) NOT NULL AUTO_INCREMENT,
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_comment_parent_id` int(11) DEFAULT NULL,
  `post_comment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `post_comment_content` text NOT NULL,
  PRIMARY KEY (`post_comment_id`),
  KEY `post_id` (`post_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `posts_comments_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`),
  CONSTRAINT `posts_comments_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts_comments`
--

LOCK TABLES `posts_comments` WRITE;
/*!40000 ALTER TABLE `posts_comments` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts_comments` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `posts_imgs`
--

DROP TABLE IF EXISTS `posts_imgs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `posts_imgs` (
  `post_id` int(11) NOT NULL,
  `post_img` varchar(255) NOT NULL,
  PRIMARY KEY (`post_id`,`post_img`),
  CONSTRAINT `posts_imgs_ibfk_1` FOREIGN KEY (`post_id`) REFERENCES `posts` (`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `posts_imgs`
--

LOCK TABLES `posts_imgs` WRITE;
/*!40000 ALTER TABLE `posts_imgs` DISABLE KEYS */;
/*!40000 ALTER TABLE `posts_imgs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `profiles`
--

DROP TABLE IF EXISTS `profiles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `profiles` (
  `user_id` int(11) NOT NULL,
  `profile_picture` varchar(255) NOT NULL DEFAULT 'default_picture.jpg',
  `profile_banner` varchar(255) NOT NULL DEFAULT 'default_banner.jpg',
  `profile_bio` varchar(255) DEFAULT NULL,
  `profile_location` varchar(255) DEFAULT NULL,
  `profile_activity` varchar(255) DEFAULT NULL,
  `profile_certification` tinyint(1) NOT NULL DEFAULT '0',
  `profile_status` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`user_id`),
  CONSTRAINT `profiles_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `profiles`
--

LOCK TABLES `profiles` WRITE;
/*!40000 ALTER TABLE `profiles` DISABLE KEYS */;
INSERT INTO `profiles` VALUES (1,'default_picture.jpg','default_banner.jpg',NULL,NULL,NULL,0,1),(2,'default_picture.jpg','default_banner.jpg',NULL,NULL,NULL,0,1),(3,'default_picture.jpg','default_banner.jpg',NULL,NULL,NULL,0,1),(4,'default_picture.jpg','default_banner.jpg',NULL,NULL,NULL,0,1),(5,'default_picture.jpg','default_banner.jpg',NULL,NULL,NULL,0,1),(6,'default_picture.jpg','default_banner.jpg',NULL,NULL,NULL,0,1),(7,'default_picture.jpg','default_banner.jpg',NULL,NULL,NULL,0,1),(8,'default_picture.jpg','default_banner.jpg',NULL,NULL,NULL,0,1);
/*!40000 ALTER TABLE `profiles` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `reactions`
--

DROP TABLE IF EXISTS `reactions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `reactions` (
  `reaction_type` enum('group','page','profil') NOT NULL,
  `reaction_type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reaction_emoji` enum('react1','react2','react3','react4','react5') NOT NULL,
  PRIMARY KEY (`reaction_type`,`reaction_type_id`,`user_id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `reactions_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `reactions`
--

LOCK TABLES `reactions` WRITE;
/*!40000 ALTER TABLE `reactions` DISABLE KEYS */;
/*!40000 ALTER TABLE `reactions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `users` (
  `user_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_username` varchar(255) NOT NULL,
  `user_mail` varchar(255) NOT NULL,
  `user_password` varchar(255) NOT NULL,
  `user_firstname` varchar(255) NOT NULL,
  `user_lastname` varchar(255) NOT NULL,
  `user_birthdate` date NOT NULL,
  `user_account_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `user_account_status` enum('disable','waiting','valid') NOT NULL DEFAULT 'waiting',
  PRIMARY KEY (`user_id`),
  UNIQUE KEY `user_username` (`user_username`),
  UNIQUE KEY `user_mail` (`user_mail`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES (1,'Benjos','b_schinkel@hetic.eu','$2y$10$u7ISrJfOmz.aFxp1IYKj2O5Tp6EEVIFjBM6R0AVyeO6neS8RXTBJu','Benjamin','Schinkel','2001-12-16','2023-05-18 20:42:20','waiting'),(2,'Julien','j_heitz@hetic.eu','$2y$10$8aiPdKHdKRTDVbmOKadYju2IKWs0PwsxhRq9voCTCCPOI.vw35WUO','Julien','Heitz','2001-04-30','2023-05-18 21:16:31','waiting'),(3,'Zeroway','jeremie@hetic.Eu','$2y$10$SxyNe0.jSat5ZfrfvnibIeBjIlMfTfktR5rmAubIEP5kjLEaTaBqS','Jérémie','Herzog','2000-07-20','2023-05-19 01:26:14','waiting'),(4,'Chibredor','taladum@gmail.com','$2y$10$2a27Nnt7yuB6cGVTasXt2OJkLzKD9zbkDXh.ot1RThtnxqjVuz4/q','Tanguy','Claude','2001-03-21','2023-05-19 01:29:20','waiting'),(5,'LTOssian','l_tchitoula@hetic.eu','$2y$10$bzRa1R.roE5wG7rNZKxK5.IBM1CxYVo9ri1h.yidFX13ZsPv3Thpy','Louisan','Tchitoula','2001-10-10','2023-05-19 14:29:44','waiting'),(6,'TainaMarie','m_rene@hetic.eu','$2y$10$fDYcEn2IezomlYsyjXvKe.Mm8Xe6t/r3u7CZJSKKV.HeO9rKohk5y','Marie','René','1997-12-12','2023-05-19 14:32:47','waiting'),(7,'Tati','mg_fahem@hetic.eu','$2y$10$rZqWD3d6JNzh.ZA7OWlZ6OGfbcWEq9ZWFbrbE2EdszuttcfmaW72G','Gwen','Fahem','1993-06-17','2023-05-19 14:34:03','waiting'),(8,'SoLaLune','a_garau@hetic.eu','$2y$10$QIrownMC5mQIFO3bbugzs.mm8QwVYrWDTlfUkxHHZeZdzjHiSvfAm','Alessandro','Garau','2000-08-10','2023-05-19 14:43:32','waiting');
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2023-05-20 22:18:46