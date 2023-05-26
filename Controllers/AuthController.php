<?php

namespace AuthController;

// Models
use Users\User;
use Profiles\Profile;
use Authentifications\Authentification;
// Src
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
        require_once '../src/functions.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
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
                
                $mail = filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL) ? filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL) : false;
                if(!$mail && !$this->_error) { $this->_error = "Mail invalide"; }
                
                $password = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST, "password")) ? filter_input(INPUT_POST, "password") : false;
                $password2 = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST, "password2")) ? filter_input(INPUT_POST, "password2") : false;
                if((!$password || !$password2) && !$this->_error) { $this->_error = "Mot de passe invalide :" . "<br>" . "-8 à 100 caractères" . "<br>" . "-1 majuscule" . "<br>" . "-1 minuscule" . "<br>" . "-1 chiffre" . "<br>" . "-1 caractère spécial"; }
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
                    setcookie('uniCookieAgent', $_SERVER['HTTP_USER_AGENT'], time()+(30*24*60*60));
                    setcookie('uniCookieToken', $token, time()+(30*24*60*60));
                    $user = $this->_modelUser->getUserByID($user["user_id"]);
                    sendMail($user["user_id"], $user["user_firstname"], $user["user_lastname"], $user["user_mail"]);
                    header("Location: index.php?p=feed");
                    exit();
                } 
                
                break;
        }        

        require_once '../Views/register.php';
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
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_modelUser = new User();
        $this->_modelAuth = new Authentification();
        
        switch ($this->_method){
            case "POST" :
                // Check User informations
                $mail = filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL) ? filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL) : false;
                if(!$mail && !$this->_error) { $this->_error = "Mail invalide"; }

                $password = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST, "password")) ? filter_input(INPUT_POST, "password") : false;
                if(!$password && !$this->_error) { $this->_error = "Mot de passe invalide :" . "<br>" . "-8 à 100 caractères" . "<br>" . "-1 majuscule" . "<br>" . "-1 minuscule" . "<br>" . "-1 chiffre" . "<br>" . "-1 caractère spécial"; }

                if(!$this->_modelUser->checkMail($mail) && !$this->_error) { $this->_error = "Identifiants incorrect"; }

                // Login and create token and cookies
                if(!$this->_error){
                    if($this->_modelUser->loginUser($mail, $password)){
                        $user = $this->_modelUser->getUser($mail);
                        $token = $this->_modelAuth->createToken($user);
                        setcookie('uniCookieUserID', $user["user_id"], time()+(30*24*60*60));
                        setcookie('uniCookieAgent', $_SERVER['HTTP_USER_AGENT'], time()+(30*24*60*60));
                        setcookie('uniCookieToken', $token, time()+(30*24*60*60));
                        header("Location: index.php?p=feed");
                        exit();
                    } else {
                        $this->_error = "Identifiants incorrect";
                    }
                }

                break;
        }
        
        require_once '../Views/login.php';
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
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_type = preg_match("`^(device|allDevice)$`", filter_input(INPUT_GET, "type")) ? filter_input(INPUT_GET, "type") : '';
        $this->_modelAuth = new Authentification();

        
        // Delete token and cookies
        switch ($this->_type){
            case "device":
                $token = $this->_modelAuth->deleteToken($_COOKIE['uniCookieUserID'], $_COOKIE['uniCookieAgent']);
                $this->deleteCookies();
                break;
            case "allDevice":
                $token = $this->_modelAuth->deleteAllToken($_COOKIE['uniCookieUserID']);
                $this->deleteCookies();
                break;
        }
        header("Location: index.php");
        exit();
    }

    private function deleteCookies(){
        setcookie('uniCookieUserID', '', time()-3600);
        setcookie('uniCookieAgent', '', time()-3600);
        setcookie('uniCookieToken', '', time()-3600);
    }
}

// VALIDATE USER
class ValidateController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private string $_type;
    private string $_id;
    private User $_modelUser;
    private Authentification $_modelAuth;

    public function __construct($page, $method){
        require_once '../Models/Users.php';
        require_once '../Models/Authentifications.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_type = preg_match("`^(valid)$`", filter_input(INPUT_GET, "type")) ? filter_input(INPUT_GET, "type") : '';
        $this->_id = ($_COOKIE['uniCookieUserID'] === filter_input(INPUT_GET, "id")) ? filter_input(INPUT_GET, "id") : '';
        $this->_modelUser = new User();
        $this->_modelAuth = new Authentification();

        $user = $this->_modelUser->getUserByID($this->_id);
        
        if($this->_id && $user["user_account_status"] == 'waiting'){
            $this->_modelUser->updateStatus($this->_id, $this->_type);
            header("Location: index.php?p=feed&success=valid"); 
            exit();
        } else {
            header("Location: index.php?p=feed&success=error"); 
            exit();
        }
    }
}

// RESEND MAIL
class ResendMailController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private User $_modelUser;

    public function __construct($page, $method){  
        require_once '../Models/Users.php';
        require_once '../src/functions.php';
      
        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_modelUser = new User();

        $user = $this->_modelUser->getUserByID($_COOKIE['uniCookieUserID']);
        sendMail($user["user_id"], $user["user_firstname"], $user["user_lastname"], $user["user_mail"]);
        header("Location: index.php?p=userOptions");
        exit();
    }

}

class FeedRouter {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private $_error;
    
    public function __construct($page, $method){        
        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');

        require_once '../Views/feed.php';
    }
}

class PostRouter
{
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private $_error;

    public function __construct($page, $method)
    {
        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');

        require_once '../Views/post.php';
    }
}

class SearchRouter {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private $_error;

    public function __construct($page, $method)
    {
        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');

        require_once '../Views/search.php';
    }

}

class PagesRouter {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private $_error;

    public function __construct($page, $method)
    {
        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');

        require_once '../Views/pages.php';
    }

}

class PageRouter {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private $_error;

    public function __construct($page, $method)
    {
        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');

        require_once '../Views/page.php';
    }

}