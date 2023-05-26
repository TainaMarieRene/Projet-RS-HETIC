<?php

namespace ProfileController;

// Models
use Profiles\Profile;
use Users\User;
use Posts\Post;
use Comments\Comment;
// Src
require_once '../src/Helpers.php';
use Helpers\Helpers;
use DateTime;

class ProfileController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private Profile $_modelProfile;
    private User $_modelUser;
    private Post $_modelPost;
    private Comment $_modelComment;
    private $_error;

    public function __construct($page, $method){
        require_once '../Models/Profiles.php';
        require_once '../Models/Users.php';
        require_once '../Models/Posts.php';
        require_once '../Models/Comments.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_modelProfile = new Profile();
        $this->_modelUser = new User();
        $this->_modelPost = new Post();
        $this->_modelComment = new Comment();

        $profile = $this->_modelProfile->getProfileInfo((filter_input(INPUT_GET, "profile_id")));
        $user = $this->_modelUser->getUserByID((filter_input(INPUT_GET, "profile_id")));
        
        if(!$profile || !$user){
            header("Location: index.php?p=404");
            exit();
        }

        switch($this->_method){
            case "POST":
                if(filter_input(INPUT_POST, "typeForme") === "post"){
                    $postContent = preg_match("`^.+$`" , preg_replace("`^\s+|\s+$|^$`", '', filter_input(INPUT_POST, "postContent"))) ? preg_replace("`^\s+|\s+$|^$`", '', filter_input(INPUT_POST, "postContent")) : false;
                    if(!$postContent && !$this->_error) { $this->_error = "Contenue invalide"; }
                    
                    if($postContent && isset($_FILES['postImg']) && $_FILES['postImg']['error'] === UPLOAD_ERR_OK){
                        $postImg = file_get_contents($_FILES['postImg']['tmp_name']);
                        $postImgHash = hash('sha256', $postImg);
                        $postImgExtension = pathinfo($_FILES['postImg']['name'], PATHINFO_EXTENSION);
                        $postImgPath = '../Views/assets/imgs/users/posts/' . $postImgHash . '.' . $postImgExtension;
                        file_put_contents($postImgPath, $postImg);
                        $postImgPath = $postImgHash . '.' . $postImgExtension;
                        $this->_modelPost->createPost($_COOKIE['uniCookieUserID'], "profile", $_COOKIE['uniCookieUserID'], $postContent, $postImgPath);
                    } elseif ($postContent){
                        $this->_modelPost->createPost($_COOKIE['uniCookieUserID'], "profile", $_COOKIE['uniCookieUserID'], $postContent);
                    }
                    break;
                } elseif (filter_input(INPUT_POST, "typeForme") === "postComment"){
                    $commentContent = preg_match("`^.+$`" , preg_replace("`^\s+|\s+$|^$`", '', filter_input(INPUT_POST, "commentContent"))) ? preg_replace("`^\s+|\s+$|^$`", '', filter_input(INPUT_POST, "commentContent")) : false;
                    if(!$commentContent && !$this->_error) { $this->_error = "Contenue invalide"; }
                    $post_id = preg_match("`^[0-9]+$`", filter_input(INPUT_POST, "postId", FILTER_VALIDATE_INT))? filter_input(INPUT_POST, "postId", FILTER_VALIDATE_INT) : false;
                    if(!$this->_modelPost->getPostById($post_id) && !$this->_error) { $this->_error = "Un problème est survenu"; }

                    if(!$this->_error){
                        $this->_modelComment->createComment($post_id, $_COOKIE['uniCookieUserID'], $commentContent);
                    }
                } elseif (filter_input(INPUT_POST, "typeForme") === "postCommentComment") {
                    $commentCommentContent = preg_match("`^.+$`" , preg_replace("`^\s+|\s+$|^$`", '', filter_input(INPUT_POST, "commentCommentContent"))) ? preg_replace("`^\s+|\s+$|^$`", '', filter_input(INPUT_POST, "commentCommentContent")) : false;
                    if(!$commentCommentContent && !$this->_error) { $this->_error = "Contenue invalide"; }
                    $post_id = preg_match("`^[0-9]+$`", filter_input(INPUT_POST, "postId", FILTER_VALIDATE_INT))? filter_input(INPUT_POST, "postId", FILTER_VALIDATE_INT) : false;
                    if(!$this->_modelPost->getPostById($post_id) && !$this->_error) { $this->_error = "Un problème est survenu"; }
                    $post_comment_id = preg_match("`^[0-9]+$`", filter_input(INPUT_POST, "commentId", FILTER_VALIDATE_INT))? filter_input(INPUT_POST, "commentId", FILTER_VALIDATE_INT) : false;
                    if(!$this->_modelComment->getCommentById($post_comment_id) && !$this->_error) { $this->_error = "Un problème est survenu"; }


                    if(!$this->_error){
                        $this->_modelComment->createComment($post_id, $_COOKIE['uniCookieUserID'], $commentCommentContent, $post_comment_id);
                    }
                }
        }

        $userPosts = $this->_modelPost->getUserProfilePosts((filter_input(INPUT_GET, "profile_id")));

        require_once '../Views/profile.php';

    }

    public function getNewDate($dateString){
                $dateTime = new DateTime($dateString);
                $currentDateTime = new DateTime();
                
                $diff = $currentDateTime->diff($dateTime);
                
                if ($diff->y > 0) {
                    return $diff->y . " an(s) ";
                } elseif ($diff->m > 0) {
                    return $diff->m . " mois ";
                } elseif ($diff->d > 0) {
                    return $diff->d . " jour(s) ";
                } elseif ($diff->h > 0) {
                    return $diff->h . " heure(s) ";
                } elseif ($diff->i > 0) {
                    return $diff->i . " minute(s) ";
                } else {
                    return $diff->s . " seconde(s) ";
                }
                
    }
}