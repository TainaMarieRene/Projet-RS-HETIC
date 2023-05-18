<?php

namespace Router;

require '/Applications/MAMP/htdocs/Projet-RS-HETIC/Controllers/AuthController.php';
use AuthController\LoginController;
use AuthController\RegisterController;

class Router {
    private string $_method;
    private string $_page;
    private $_controller;

    public function __construct(){
        $this->_method = filter_input(INPUT_SERVER, "REQUEST_METHOD");

        switch($this->_method){
            case "GET":
                $this->_page = filter_input(INPUT_GET, "p") ? filter_input(INPUT_GET, "p") : "login";
                break;
            case "POST":
                $this->_page = filter_input(INPUT_GET, "p") ? filter_input(INPUT_GET, "p") : "login";
                break;
        }

        switch($this->_page){
            case "login":
                $this->_controller = new LoginController($this->_page, $this->_method);
                break;
            case "register":
                $this->_controller = new RegisterController($this->_page, $this->_method);
                break;
            default:
                echo("404");
                break;
        }
    }
}