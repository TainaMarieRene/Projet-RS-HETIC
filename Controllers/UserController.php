<?php

namespace UserController;

// Models
use Users\User;
use Profiles\Profile;
use Authentifications\Authentification;
use Posts\Post;
use Reactions\Reaction;
// src
require_once '../src/Helpers.php';
use Helpers\Helpers;

class UserOptionsController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private User $_modelUser;
    private $_error;

    public function __construct($page, $method){
        require_once '../Models/Users.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_modelUser = new User();

        $user = $this->_modelUser->getUserByID($_COOKIE['uniCookieUserID']);

        $currentPassword = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST,"currentPassword")) ? filter_input(INPUT_POST,"currentPassword") : false;
        if (!$currentPassword && !$this->_error) { $this->_error = "Mot de passe invalide !"; }
        if (!$this->_error) {
            if($this->_modelUser->loginUser($user["user_mail"], $currentPassword)) {
                $password1 = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST,"password1")) ? filter_input(INPUT_POST,"password1") : false;
                $password2 = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST,"password2")) ? filter_input(INPUT_POST,"password2") : false;
                if ((!$password1 || !$password2) && !$this->_error) { $this->_error = "Nouveau mot de passe invalide !"; }
                if ($password1 == $password2) {
                    $this->_modelUser->changePassword($_COOKIE['uniCookieUserID'], $password1);
                } else {
                    $this->_error = "Les mots de passe ne correspondent pas !";
                }
            } else {
                $this->_error = "Mot de passe incorrecte !";
            }
        }

        require_once '../Views/userOptions.php';
    }
}

class UpdateUserStatusController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private string $_type;
    private User $_modelUser;

    public function __construct($page, $method){
        require_once '../Models/Users.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_type = preg_match("`^(valid|disable)$`", filter_input(INPUT_GET, "type")) ? filter_input(INPUT_GET, "type") : '';
        $this->_modelUser = new User();

        $this->_modelUser->updateStatus($_COOKIE['uniCookieUserID'], $this->_type);

        header("Location: index.php?p=userOptions");
        exit;
    }
}

class DeleteUserController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private User $_modelUser;
    private Profile $_modelProfile;
    private Authentification $_modelAuth;
    private Post $_modelPost;
    private Reaction $_modelReaction;

    public function __construct($page, $method){
        require_once '../Models/Users.php';
        require_once '../Models/Profiles.php';
        require_once '../Models/Posts.php';
        require_once '../Models/reactions.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_modelUser = new User();
        $this->_modelProfile = new Profile();
        $this->_modelAuth = new Authentification();
        $this->_modelPost = new Post();
        $this->_modelReaction = new Reaction();

        $this->_modelReaction->deleteAllReactions($_COOKIE['uniCookieUserID']);
        $this->_modelPost->deleteAllPosts($_COOKIE['uniCookieUserID']);
        $this->_modelProfile->deleteProfile($_COOKIE['uniCookieUserID']);
        $this->_modelUser->deleteUser($_COOKIE['uniCookieUserID']);
        header("Location: index.php?p=logout&type=allDevice");
        exit;
    }
}