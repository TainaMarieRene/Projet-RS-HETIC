<?php

namespace Router;

require '/Applications/MAMP/htdocs/Projet-RS-HETIC/Controllers/AuthController.php';
use AuthController\LoginController;
use AuthController\RegisterController;

class Router {
    private string $_methode;
    private string $_page;
    private $_controller;

    public function __construct(){
        $this->_methode = filter_input(INPUT_SERVER, "REQUEST_METHOD");

        if ($this->_methode == "GET"){
            if (filter_input(INPUT_GET, "p")){
                $this->_page = filter_input(INPUT_GET, "p");
            } else {
                $this->_page = "login";
            }
        }

        switch($this->_page){
            case "login":
                $this->_controller = new LoginController();
                break;
            case "register":
                $this->_controller = new RegisterController();
                break;
            default:
                echo("404");
                break;
        }
    }
}