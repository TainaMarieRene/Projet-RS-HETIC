<?php

namespace Router;

require_once '../Controllers/AuthController.php';
use AuthController\RegisterController;
use AuthController\LoginController;
use AuthController\LogoutController;
use AuthController\TempoController;

class Router {
    private string $_method;
    private string $_page;
    private $_controller;

    // Get the page && method and return the good controller
    public function __construct(){
        $this->_method = filter_input(INPUT_SERVER, "REQUEST_METHOD");
        $this->_page = filter_input(INPUT_GET, "p") ? filter_input(INPUT_GET, "p") : "login";

        switch($this->_page){
            case "register":
                $this->_controller = new RegisterController($this->_page, $this->_method);
                break;
            case "login":
                $this->_controller = new LoginController($this->_page, $this->_method);
                break;
            case "logout":
                $this->_controller = new LogoutController($this->_page, $this->_method);
                break;
            case "feed":
                $this->_controller = new TempoController($this->_page, $this->_method);
                break;
            default:
                // TODO : Create a 404 Page
                echo("404");
                break;
        }
    }
}