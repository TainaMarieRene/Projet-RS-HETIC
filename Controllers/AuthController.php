<?php

namespace AuthController;

class LoginController {
    private string $_page;
    private string $_method;
    
    public function __construct($page, $method){
        $this->_page = $page;
        $this->_method = $method;
        require '/Applications/MAMP/htdocs/Projet-RS-HETIC/Models/Users.php';
        require '/Applications/MAMP/htdocs/Projet-RS-HETIC/Views/login.php';
    }
}

class RegisterController {
    private string $_page;
    private string $_method;

    public function __construct($page, $method){
        $this->_page = $page;
        $this->_method = $method;
        
        switch ($this->_method){
            case "GET" :
                break;
            case "POST" :
                $firstname = preg_match("`^((?:(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+)(?:-(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))+)|(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))$`", filter_input(INPUT_POST, "firstname")) ? filter_input(INPUT_POST, "firstname") : false ;
                $lastname = preg_match("`^((?:(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+)(?:-(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))+)|(?:[a-zA-ZáâàãçéêèëïíóôõúüÁÂÀÃÇÉÈÊËÏÍÓÔÕÚÜ]+))$`", filter_input(INPUT_POST, "lastname")) ? filter_input(INPUT_POST, "lastname") : false ;
                
                $birthdate = preg_match("`^([0-9]{4})(-)(0[1-9]|1[0-2])(-)(0[1-9]|1[0-9]|2[0-9]|3[0-1])$`", filter_input(INPUT_POST, "birthdate")) ? filter_input(INPUT_POST, "birthdate") : false;
                $birthdate = ($this->checkYears($birthdate)) ? $birthdate : false;

                $username = preg_match("`^(?=.{3,20}$)(?![_.-])(?!.*[_.-]{2})[a-zA-Z0-9_-]+(?![^._-])$`", filter_input(INPUT_POST, "username")) ? filter_input(INPUT_POST, "username") : false;
                // CHECK SI PAS DEJA UTILISÉ

                $mail = preg_match("`(?xim)^(?=.*\.[A-Z]+$)(?=([[:alnum:]\.+_-]+)@(?1))(?!.*@.*@)(?!.*?@.*\.\d+$)(?!([[:punct:]]))(?!.*\.{2,})(?!.*(?2)@)(?!.*@(?2)).*`", filter_input(INPUT_POST, "mail")) ? filter_input(INPUT_POST, "mail", FILTER_VALIDATE_EMAIL) : false;
                // CHECK SI PAS DEJA UTILISÉ
                
                $password = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST, "password")) ? filter_input(INPUT_POST, "password") : false;
                $password2 = preg_match("`^(?=.*\d)(?=.*[A-Z])(?=.*[a-z])(?=.*[^\w\d\s:])([^\s]){8,100}$`" ,filter_input(INPUT_POST, "password2")) ? filter_input(INPUT_POST, "password2") : false;
                $password = ($password === $password2) ? $password : false;
                // HASH

                break;
        }        

        require '/Applications/MAMP/htdocs/Projet-RS-HETIC/Models/Users.php';
        require '/Applications/MAMP/htdocs/Projet-RS-HETIC/Views/register.php';
    }

    private function checkYears($birthdate){
        $limit = 18;
        $age = (date('md') < date('md', strtotime($birthdate))) ? (date('Y') - date('Y', strtotime($birthdate)) - 1) : (date('Y') - date('Y', strtotime($birthdate)));
        return ($limit <= $age) ? true : false;
    }

}