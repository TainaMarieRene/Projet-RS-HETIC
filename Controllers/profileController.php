<?php

namespace ProfileController;

// Models
use Profiles\Profile;
use Users\User;
use Posts\Post;
// Src
require_once '../src/Helpers.php';
use Helpers\Helpers;

class ProfileController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private Profile $_modelProfile;
    private User $_modelUser;
    private Post $_modelPost;
    private $_error;

    public function __construct($page, $method){
        require_once '../Models/Profiles.php';
        require_once '../Models/Users.php';
        require_once '../Models/Posts.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_modelProfile = new Profile();
        $this->_modelUser = new User();
        $this->_modelPost = new Post();

        $profile = $this->_modelProfile->getProfileInfo((filter_input(INPUT_GET, "profile_id")));
        $user = $this->_modelUser->getUserByID((filter_input(INPUT_GET, "profile_id")));
        
        switch($this->_method){
            case "POST":
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
        }

        $userPosts = $this->_modelPost->getUserProfilePosts((filter_input(INPUT_GET, "profile_id")));

        require_once '../Views/profile.php';
    }
}