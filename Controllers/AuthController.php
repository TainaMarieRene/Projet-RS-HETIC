<?php

namespace AuthController;

class LoginController {
    public function __construct(){
        require '/Applications/MAMP/htdocs/Projet-RS-HETIC/Models/Users.php';
        require '/Applications/MAMP/htdocs/Projet-RS-HETIC/Views/login.php';
    }
}

class RegisterController {
    public function __construct(){
        require '/Applications/MAMP/htdocs/Projet-RS-HETIC/Models/Users.php';
        require '/Applications/MAMP/htdocs/Projet-RS-HETIC/Views/register.php';
    }
}