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
    private Profile $_modelProfile;
    private $_error;
    private $_success;

    public function __construct($page, $method){
        require_once '../Models/Users.php';
        require_once '../Models/Profiles.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_modelUser = new User();
        $this->_modelProfile = new Profile();

        $user = $this->_modelUser->getUserByID($_COOKIE['uniCookieUserID']);
        $profile = $this->_modelProfile->getProfileInfo($_COOKIE['uniCookieUserID']);

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
                if($user_birthdate != $user["user_birthdate"]){
                    $user_birthdate = preg_match("`^([0-9]{4})(-)(0[1-9]|1[0-2])(-)(0[1-9]|1[0-9]|2[0-9]|3[0-1])$`", filter_input(INPUT_POST, "userBirthdate")) ? filter_input(INPUT_POST, "userBirthdate") : false;
                    if (!$user_birthdate && !$this->_error) { $this->_error = "Date de naissance invalide !"; }
                    $user_birthdate = $this->checkYears($user_birthdate);
                    if(!$user_birthdate && !$this->_error) { $this->_error = "Vous n'avez pas l'age requis"; }
                    if (!$this->_error) {
                        $this->_modelUser->changeUserBirthdate($_COOKIE['uniCookieUserID'], $user_birthdate);
                        $this->_success = "Date de naissance modifié !";
                        $user["user_birthdate"] = $user_birthdate;
                    }
                }
                // Changer la bio
                $profile_bio = filter_input(INPUT_POST, "profileBio");
                if($profile_bio !=$profile["profile_bio"]) {
                    $profile_bio = preg_match("`^.+$`" , preg_replace("`^\s+|\s+$|^$`", '', filter_input(INPUT_POST, "profileBio"))) ? preg_replace("`^\s+|\s+$|^$`", '', filter_input(INPUT_POST, "profileBio")) : false;
                    if (!$this->_error) {
                        $this->_modelUser->changeUserProfileBio($profile_bio, $_COOKIE['uniCookieUserID']);
                        $this->_success = "Bio modifiée !";
                        $profile["profile_bio"] = $profile_bio;
                    }
                }
                // Changer la localisation
                $profile_location = filter_input(INPUT_POST, "profileLocation");
                if ($profile_location !=$profile["profile_location"]) {
                    $profile_location = preg_match("`^.+$`" , preg_replace("`^\s+|\s+$|^$`", '', filter_input(INPUT_POST, "profileLocation"))) ? preg_replace("`^\s+|\s+$|^$`", '', filter_input(INPUT_POST, "profileLocation")) : false;
                    if (!$this->_error) {
                        $this->_modelUser->changeProfileLocation($profile_location, $_COOKIE['uniCookieUserID']);
                        $this->_success = "Localisation modifiée !";
                        $profile["profile_location"] = $profile_location;
                    }
                }
                // Changer l'activité
                $profile_activity = filter_input(INPUT_POST, "profileActivity");
                if ($profile_activity !=$profile["profile_activity"]) {
                    $profile_activity = preg_match("`^.+$`" , preg_replace("`^\s+|\s+$|^$`", '', filter_input(INPUT_POST, "profileActivity"))) ? preg_replace("`^\s+|\s+$|^$`", '', filter_input(INPUT_POST, "profileActivity")) : false;
                    if (!$this->_error) {
                        $this->_modelUser->changeProfileActivity($profile_activity, $_COOKIE['uniCookieUserID']);
                        $this->_success = "Activité modifiée !";
                        $profile["profile_activity"] = $profile_activity;
                    }
                }
                // Changer la photo de profile
                if(isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK){
                    $profile_picture = file_get_contents($_FILES['profile_picture']['tmp_name']);
                    $profile_pictureHash = hash('sha256', $profile_picture);
                    $profile_pictureExtension = pathinfo($_FILES['profile_picture']['name'], PATHINFO_EXTENSION);
                    $profile_picturePath = '../Views/assets/imgs/users/picture/' . $profile_pictureHash . '.' . $profile_pictureExtension;
                    file_put_contents($profile_picturePath, $profile_picture);
                    $profile_picturePath = $profile_pictureHash . '.' . $profile_pictureExtension;
                    $this->_modelProfile->changeProfileImg("profile_picture", $profile_picturePath, $_COOKIE['uniCookieUserID']);
                    if($profile["profile_picture"] != "default_picture.jpg" && !$this->_modelProfile->imgIsUse("profile_picture", $profile["profile_picture"])){
                        unlink("../Views/assets/imgs/users/picture/" . $profile["profile_picture"]);
                    }
                    $profile["profile_picture"] = $profile_picturePath;
                }
                // Changer la bannière
                if(isset($_FILES['profile_banner']) && $_FILES['profile_banner']['error'] === UPLOAD_ERR_OK){
                    $profile_banner = file_get_contents($_FILES['profile_banner']['tmp_name']);
                    $profile_bannerHash = hash('sha256', $profile_banner);
                    $profile_bannerExtension = pathinfo($_FILES['profile_banner']['name'], PATHINFO_EXTENSION);
                    $profile_bannerPath = '../Views/assets/imgs/users/banner/' . $profile_bannerHash . '.' . $profile_bannerExtension;
                    file_put_contents($profile_bannerPath, $profile_banner);
                    $profile_bannerPath = $profile_bannerHash . '.' . $profile_bannerExtension;
                    $this->_modelProfile->changeProfileImg("profile_banner", $profile_bannerPath, $_COOKIE['uniCookieUserID']);
                    if($profile["profile_banner"] != "default_banner.jpg" && !$this->_modelProfile->imgIsUse("profile_banner", $profile["profile_banner"])){
                        unlink("../Views/assets/imgs/users/banner/" . $profile["profile_banner"]);
                    }
                    $profile["profile_banner"] = $profile_bannerPath;
                }
            break;
        }

        require_once '../Views/userOptions.php';
    }

    private function checkYears($birthdate){
        $limit = 18;
        $age = (date('md') < date('md', strtotime($birthdate))) ? (date('Y') - date('Y', strtotime($birthdate)) - 1) : (date('Y') - date('Y', strtotime($birthdate)));
        return ($age >= $limit && $age <= 120) ? $birthdate : false;
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