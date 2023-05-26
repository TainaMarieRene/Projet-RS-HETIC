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

        switch ($this->_method) {
            case "POST" : 
                // Changer le username 
                $user_username = filter_input(INPUT_POST, "userName");
                if($user_username != $user["user_username"]){
                    $user_username = preg_match("`^(?=.{3,20}$)(?![_.-])(?!.*[_.-]{2})[a-zA-Z0-9_-]+(?![^._-])$`", filter_input(INPUT_POST, "userName")) ? filter_input(INPUT_POST, "userName") : false;
                    if (!$user_username && !$this->_error) { $this->_error = "Username invalide !"; }
                    if (!$this->_error) {
                        if ($this->_modelUser->checkUsername($user_username)) {
                            $this->_error = "Pseudo indisponible !";
                        } else {
                            $this->_modelUser->changeUsername($_COOKIE['uniCookieUserID'], $user_username);
                            $this->_success = "Pseudo modifié !";
                            $user["user_username"] = $user_username;
                        }
                    }
                }
                // Changer l'email
                $usermail = filter_input(INPUT_POST, "userMail");
                if($usermail !=$user["user_mail"]){
                    $usermail = filter_input(INPUT_POST, "userMail", FILTER_VALIDATE_EMAIL) ? filter_input(INPUT_POST, "userMail", FILTER_VALIDATE_EMAIL) : false;
                    if (!$usermail && !$this->_error) { $this->_error = "Mail invalide !"; }
                    if (!$this->_error) {
                        if($this->_modelUser->checkMail($usermail)) {
                            $this->_error = "Cet email est déjà utilisé !";
                        } else {
                            $this->_modelUser->changeUsermail($_COOKIE['uniCookieUserID'], $usermail);
                            $this->_success = "Mail modifié !";
                            $user["user_mail"] = $usermail;
                        }
                    }
                }
                // Changer le password
                $currentPassword = filter_input(INPUT_POST,"currentPassword");
                $password1 = filter_input(INPUT_POST,"password1");
                $password2 = filter_input(INPUT_POST,"password2");
                if($currentPassword || $password1 || $password2){
                    $currentPassword = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST,"currentPassword")) ? filter_input(INPUT_POST,"currentPassword") : false;
                    if (!$currentPassword && !$this->_error) { $this->_error = "Mot de passe invalide !"; }
                    if (!$this->_error) {
                        if($this->_modelUser->loginUser($user["user_mail"], $currentPassword)) {
                            $password1 = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST,"password1")) ? filter_input(INPUT_POST,"password1") : false;
                            $password2 = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST,"password2")) ? filter_input(INPUT_POST,"password2") : false;
                            if ((!$password1 || !$password2) && !$this->_error) { $this->_error = "Nouveau mot de passe invalide !"; }
                            if ($password1 == $password2) {
                                $this->_modelUser->changePassword($_COOKIE['uniCookieUserID'], $password1);
                                $this->_success = "Mot de passe modifié !";
                            } else {
                                $this->_error = "Les mots de passe ne correspondent pas !";
                            }
                        } else {
                            $this->_error = "Mot de passe incorrecte !";
                        }
                    }
                }
                // Changer le prénom
                $user_firstname = filter_input(INPUT_POST, "userFirstname");
                if($user_firstname !=$user["user_firstname"]){
                    $user_firstname = preg_match("`^((?:(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+)(?:-(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))+)|(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))$`", filter_input(INPUT_POST, "userFirstname")) ? filter_input(INPUT_POST, "userFirstname") : false ;
                    if (!$user_firstname && !$this->_error) { $this->_error = "Prénom invalide !"; }
                    if (!$this->_error) {
                        $this->_modelUser->changeUserFirstname($_COOKIE['uniCookieUserID'], $user_firstname);
                        $this->_success = "Prénom modifié !";
                        $user["user_firstname"] = $user_firstname;
                    }
                }
                // Changer le nom
                $user_lastname = filter_input(INPUT_POST, "userLastname");
                if($user_lastname !=$user["user_lastname"]){
                    $user_lastname = preg_match("`^((?:(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+)(?:-(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))+)|(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))$`", filter_input(INPUT_POST, "userLastname")) ? filter_input(INPUT_POST, "userLastname") : false ;
                    if (!$user_lastname && !$this->_error) { $this->_error = "Nom invalide !"; }
                    if (!$this->_error) {
                        $this->_modelUser->changeUserLastname($_COOKIE['uniCookieUserID'], $user_lastname);
                        $this->_success = "Nom modifié !";
                        $user["user_lastname"] = $user_lastname;
                    }
                }
                // Changer la date de naissance
                $user_birthdate = filter_input(INPUT_POST, "userBirthdate");
                if($user_birthdate !=$user["userBirthdate"]){
                    $user_birthdate = preg_match("`^([0-9]{4})(-)(0[1-9]|1[0-2])(-)(0[1-9]|1[0-9]|2[0-9]|3[0-1])$`", filter_input(INPUT_POST, "userBirthdate")) ? filter_input(INPUT_POST, "userBirthdate") : false;
                    if (!$user_birthdate && !$this->_error) { $this->_error = "Date de naissance invalide !"; }
                    if (!$this->_error) {
                        $this->_modelUser->changeUserBirthdate($_COOKIE['uniCookieUserID'], $user_birthdate);
                        $this->_success = "Date de naissance modifié !";
                    }
                }
            break;
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