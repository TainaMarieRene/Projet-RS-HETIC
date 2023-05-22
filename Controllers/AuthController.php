<?php

namespace AuthController;

use Users\User;
use Profiles\Profile;
use Authentifications\Authentification;
require_once '../src/Helpers.php';
use Helpers\Helpers;

// REGISTER
class RegisterController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private User $_modelUser;
    private Profile $_modelProfile;
    private Authentification $_modelAuth;
    private $_error;

    public function __construct($page, $method){
        require_once '../Models/Users.php';
        require_once '../Models/Profiles.php';
        require_once '../Models/Authentifications.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUsername']) ? $_COOKIE['uniCookieUsername'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '', isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '');
        $this->_modelUser = new User();
        $this->_modelProfile = new Profile();
        $this->_modelAuth = new Authentification();
        
        switch ($this->_method){
            case "POST" :
                // Check User informations
                $firstname = preg_match("`^((?:(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+)(?:-(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))+)|(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))$`", filter_input(INPUT_POST, "firstname")) ? filter_input(INPUT_POST, "firstname") : false ;
                if(!$firstname && !$this->_error) { $this->_error = "Prénom invalide"; }

                $lastname = preg_match("`^((?:(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+)(?:-(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))+)|(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))$`", filter_input(INPUT_POST, "lastname")) ? filter_input(INPUT_POST, "lastname") : false ;
                if(!$lastname && !$this->_error) { $this->_error = "Nom invalide"; }
                
                $birthdate = preg_match("`^([0-9]{4})(-)(0[1-9]|1[0-2])(-)(0[1-9]|1[0-9]|2[0-9]|3[0-1])$`", filter_input(INPUT_POST, "birthdate")) ? filter_input(INPUT_POST, "birthdate") : false;
                if(!$birthdate && !$this->_error) { $this->_error = "Date de naissance invalide"; }
                $birthdate = $this->checkYears($birthdate);
                if(!$birthdate && !$this->_error) { $this->_error = "Vous n'avez pas l'age requis"; }
                
                $username = preg_match("`^(?=.{3,20}$)(?![_.-])(?!.*[_.-]{2})[a-zA-Z0-9_-]+(?![^._-])$`", filter_input(INPUT_POST, "username")) ? filter_input(INPUT_POST, "username") : false;
                if(!$username && !$this->_error) { $this->_error = "Identifiant invalide"; }
                
                $mail = preg_match("`(?xim)^(?=.*\.[A-Z]+$)(?=([[:alnum:]\.+_-]+)@(?1))(?!.*@.*@)(?!.*?@.*\.\d+$)(?!([[:punct:]]))(?!.*\.{2,})(?!.*(?2)@)(?!.*@(?2)).*`", filter_input(INPUT_POST, "mail")) ? filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL) : false;
                if(!$mail && !$this->_error) { $this->_error = "Mail invalide"; }
                
                $password = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST, "password")) ? filter_input(INPUT_POST, "password") : false;
                $password2 = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST, "password2")) ? filter_input(INPUT_POST, "password2") : false;
                if((!$password || !$password2) && !$this->_error) { $this->_error = "Mot de passe invalide (Longueur de 8 à 100 caractères avec minimum : 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spéciaux)"; }
                $password = $this->checkPassword($password, $password2);
                if(!$password && !$this->_error) { $this->_error = "Les mots de passe ne correspondent pas"; }
                
                // Check username && mail free
                if($this->_modelUser->checkUsername($username) && !$this->_error) { $this->_error = "Identifiant déjà utilisé"; }
                if($this->_modelUser->checkMail($mail) && !$this->_error) { $this->_error = "Mail déjà utilisé"; }
                
                // Create the user and the profile
                if(!$this->_error){
                    $user = $this->_modelUser->createUser($firstname, $lastname, $birthdate, $username, $mail, $password);
                    $this->_modelProfile->createProfile($user);
                    $token = $this->_modelAuth->createToken($user);
                    setcookie('uniCookieUserID', $user["user_id"], time()+(30*24*60*60));
                    setcookie('uniCookieUsername', $user["user_username"], time()+(30*24*60*60));
                    setcookie('uniCookieAgent', $_SERVER['HTTP_USER_AGENT'], time()+(30*24*60*60));
                    setcookie('uniCookieToken', $token, time()+(30*24*60*60));
                    header("Location: index.php?p=feed");
                    exit();
                } 
                
                break;
        }        

        require_once '../Views/register.php';
        if($this->_error){ return $this->_error; }
    }

    private function checkYears($birthdate){
        $limit = 18;
        $age = (date('md') < date('md', strtotime($birthdate))) ? (date('Y') - date('Y', strtotime($birthdate)) - 1) : (date('Y') - date('Y', strtotime($birthdate)));
        return ($age >= $limit && $age <= 120) ? $birthdate : false;
    }

    private function checkPassword($password, $password2){
        return ($password === $password2) ? $password : false;
    }
}

// LOGIN
class LoginController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private User $_modelUser;
    private Authentification $_modelAuth;
    private $_error;
    
    public function __construct($page, $method){
        require_once '../Models/Users.php';
        require_once '../Models/Authentifications.php';
        
        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUsername']) ? $_COOKIE['uniCookieUsername'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '', isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '');
        $this->_modelUser = new User();
        $this->_modelAuth = new Authentification();
        
        switch ($this->_method){
            case "POST" :
                // Check User informations
                $mail = preg_match("`(?xim)^(?=.*\.[A-Z]+$)(?=([[:alnum:]\.+_-]+)@(?1))(?!.*@.*@)(?!.*?@.*\.\d+$)(?!([[:punct:]]))(?!.*\.{2,})(?!.*(?2)@)(?!.*@(?2)).*`", filter_input(INPUT_POST, "mail")) ? filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL) : false;
                if(!$mail && !$this->_error) { $this->_error = "Mail invalide"; }

                $password = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST, "password")) ? filter_input(INPUT_POST, "password") : false;
                if(!$password && !$this->_error) { $this->_error = "Mot de passe invalide (Longueur de 8 à 100 caractères avec minimum : 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spéciaux)"; }

                if(!$this->_modelUser->checkMail($mail) && !$this->_error) { $this->_error = "Aucun compte enregistré à l'adresse mail que vous avez renseigné"; }

                // Login and create token and cookies
                if(!$this->_error){
                    if($this->_modelUser->loginUser($mail, $password)){
                        $user = $this->_modelUser->getUser($mail);
                        $token = $this->_modelAuth->createToken($user);
                        setcookie('uniCookieUserID', $user["user_id"], time()+(30*24*60*60));
                        setcookie('uniCookieUsername', $user["user_username"], time()+(30*24*60*60));
                        setcookie('uniCookieAgent', $_SERVER['HTTP_USER_AGENT'], time()+(30*24*60*60));
                        setcookie('uniCookieToken', $token, time()+(30*24*60*60));
                        header("Location: index.php?p=feed");
                        exit();
                    } else {
                        $this->_error = "Mauvais mot de passe";
                    }
                }

                break;
        }
        
        require_once '../Views/login.php';
        if($this->_error){ return $this->_error; }
    }
}

// LOGOUT
class LogoutController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private $_type;
    private Authentification $_modelAuth;
    
    public function __construct($page, $method){   
        require_once '../Models/Authentifications.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUsername']) ? $_COOKIE['uniCookieUsername'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '', isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '');
        $this->_type = preg_match("`^(device|allDevice)$`", filter_input(INPUT_GET, "type")) ? filter_input(INPUT_GET, "type") : '';
        $this->_modelAuth = new Authentification();

        
        // Delete token and cookies
        switch ($this->_type){
            case "device":
                $token = $this->_modelAuth->deleteToken($_COOKIE['uniCookieUsername'], $_COOKIE['uniCookieAgent'], $_COOKIE['uniCookieUserID']);
                $this->deleteCookies();
                break;
            case "allDevice":
                $token = $this->_modelAuth->deleteAllToken($_COOKIE['uniCookieUsername'], $_COOKIE['uniCookieUserID']);
                $this->deleteCookies();
                break;
        }
        header("Location: index.php");
        exit();
    }

    private function deleteCookies(){
        setcookie('uniCookieUserID', '', time()-3600);
        setcookie('uniCookieUsername', '', time()-3600);
        setcookie('uniCookieAgent', '', time()-3600);
        setcookie('uniCookieToken', '', time()-3600);
    }
}

class TempoController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private $_error;
    
    public function __construct($page, $method){        
        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUsername']) ? $_COOKIE['uniCookieUsername'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '', isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '');
        
        require_once '../Views/tempofeed.php';
        if($this->_error){ return $this->_error; }
    }
}