<?php

namespace AuthController;
use Users\User;
use Profiles\Profile;

// LOGIN
class LoginController {
    private string $_page;
    private string $_method;
    private User $_modelUser;
    private $_error;
    
    public function __construct($page, $method){
        require '../Models/Users.php';
        
        $this->_page = $page;
        $this->_method = $method;
        $this->_modelUser = new User();
        
        switch ($this->_method){
            case "POST" :
                $mail = preg_match("`(?xim)^(?=.*\.[A-Z]+$)(?=([[:alnum:]\.+_-]+)@(?1))(?!.*@.*@)(?!.*?@.*\.\d+$)(?!([[:punct:]]))(?!.*\.{2,})(?!.*(?2)@)(?!.*@(?2)).*`", filter_input(INPUT_POST, "mail")) ? filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL) : false;
                if(!$mail && !$this->_error) { $this->_error = "Mail invalide"; }

                $password = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST, "password")) ? filter_input(INPUT_POST, "password") : false;
                if(!$password && !$this->_error) { $this->_error = "Mot de passe invalide (Longueur de 8 à 100 caractères avec minimum : 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spéciaux)"; }

                if(!$this->_modelUser->checkMail($mail) && !$this->_error) { $this->_error = "Aucun compte enregistré à l'adresse mail que vous avez renseigné"; }

                if(!$this->_error){
                    if($this->_modelUser->loginUser($mail, $password)){
                        echo("Connecté");
                        $_SESSION["loggedin"] = true;
                        header("Location: index.php?p=feed");
                        exit();
                    } else {
                        $this->_error = "Mauvais mot de passe";
                    }
                }

                break;
        }
        
        require '../Views/login.php';
        if($this->_error){ return $this->_error; }
    }
}

// REGISTER
class RegisterController {
    private string $_page;
    private string $_method;
    private User $_modelUser;
    private Profile $_modelProfile;
    private $_error;

    public function __construct($page, $method){
        require_once '../Models/Users.php';
        require_once '../Models/Profiles.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_modelUser = new User();
        $this->_modelProfile = new Profile();
        
        switch ($this->_method){
            case "POST" :
                // Check firstname && lastname
                $firstname = preg_match("`^((?:(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+)(?:-(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))+)|(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))$`", filter_input(INPUT_POST, "firstname")) ? filter_input(INPUT_POST, "firstname") : false ;
                if(!$firstname && !$this->_error) { $this->_error = "Prénom invalide"; }

                $lastname = preg_match("`^((?:(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+)(?:-(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))+)|(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))$`", filter_input(INPUT_POST, "lastname")) ? filter_input(INPUT_POST, "lastname") : false ;
                if(!$lastname && !$this->_error) { $this->_error = "Nom invalide"; }
                
                // Check birthdate
                $birthdate = preg_match("`^([0-9]{4})(-)(0[1-9]|1[0-2])(-)(0[1-9]|1[0-9]|2[0-9]|3[0-1])$`", filter_input(INPUT_POST, "birthdate")) ? filter_input(INPUT_POST, "birthdate") : false;
                if(!$birthdate && !$this->_error) { $this->_error = "Date de naissance invalide"; }
                $birthdate = $this->checkYears($birthdate);
                if(!$birthdate && !$this->_error) { $this->_error = "Vous n'avez pas l'age requis"; }
                
                // Check username && mail
                $username = preg_match("`^(?=.{3,20}$)(?![_.-])(?!.*[_.-]{2})[a-zA-Z0-9_-]+(?![^._-])$`", filter_input(INPUT_POST, "username")) ? filter_input(INPUT_POST, "username") : false;
                if(!$username && !$this->_error) { $this->_error = "Identifiant invalide"; }
                
                $mail = preg_match("`(?xim)^(?=.*\.[A-Z]+$)(?=([[:alnum:]\.+_-]+)@(?1))(?!.*@.*@)(?!.*?@.*\.\d+$)(?!([[:punct:]]))(?!.*\.{2,})(?!.*(?2)@)(?!.*@(?2)).*`", filter_input(INPUT_POST, "mail")) ? filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL) : false;
                if(!$mail && !$this->_error) { $this->_error = "Mail invalide"; }
                
                // Check password
                $password = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST, "password")) ? filter_input(INPUT_POST, "password") : false;
                $password2 = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST, "password2")) ? filter_input(INPUT_POST, "password2") : false;
                if((!$password || !$password2) && !$this->_error) { $this->_error = "Mot de passe invalide (Longueur de 8 à 100 caractères avec minimum : 1 majuscule, 1 minuscule, 1 chiffre, 1 caractère spéciaux)"; }
                $password = $this->checkPassword($password, $password2);
                if(!$password && !$this->_error) { $this->_error = "Les mots de passe ne correspondent pas"; }
                
                // Check username && mail free
                if($this->_modelUser->checkUsername($username) && !$this->_error) { $this->_error = "Identifiant déjà utilisé"; }
                if($this->_modelUser->checkMail($mail) && !$this->_error) { $this->_error = "Mail déjà utilisé"; }
                
                if(!$this->_error){
                    $user = $this->_modelUser->createUser($firstname, $lastname, $birthdate, $username, $mail, $password);
                    $this->_modelProfile->createProfile($user);
                    header("Location: index.php");
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

class LogoutController {
    private string $_page;
    private string $_method;
    private $_error;
    
    public function __construct($page, $method){        
        $this->_page = $page;
        $this->_method = $method;
        
        require '../Views/logout.php';
        if($this->_error){ return $this->_error; }
    }
}

class TempoController {
    private string $_page;
    private string $_method;
    private $_error;
    
    public function __construct($page, $method){        
        $this->_page = $page;
        $this->_method = $method;
        
        require '../Views/tempofeed.php';
        if($this->_error){ return $this->_error; }
    }
}