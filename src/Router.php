<?php

namespace Router;

require_once '../Controllers/AuthController.php';
use AuthController\LoginController;
use AuthController\RegisterController;

class Router {
    private string $_method;
    private string $_page;
    private $_controller;

    // Get the page && method and return the good controller
    public function __construct(){
        $this->_method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
        $this->_page = filter_input(INPUT_GET, "p") ? filter_input(INPUT_GET, "p") : "login";

        switch($this->_page){
            case "login":
                $this->_controller = new LoginController($this->_page, $this->_method);
                break;
            case "register":
                $this->_controller = new RegisterController($this->_page, $this->_method);
                break;
            default:
                // TO DO : Creat a 404 Page
                echo("404");
                break;
        }
    }
}