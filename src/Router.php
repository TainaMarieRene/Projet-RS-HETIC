<?php

namespace Router;

require_once '../Controllers/AuthController.php';
use AuthController\RegisterController;
use AuthController\LoginController;
use AuthController\LogoutController;
use AuthController\FeedController;
use AuthController\ValidateController;
use AuthController\ResendMailController;
require_once '../Controllers/UserController.php';
use UserController\UserOptionsController;
use UserController\DeleteUserController;
use UserController\UpdateUserStatusController;
require_once '../Controllers/PostController.php';
use PostController\DeletePostController;
require_once '../Controllers/HTTPResponsesController.php';
use HTTPResponses\HTTPResponseController;
require_once '../Controllers/ProfileController.php';
use ProfileController\ProfileController;

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
            case "validateUser":
                $this->_controller = new ValidateController($this->_page, $this->_method);
                break;
            case "logout":
                $this->_controller = new LogoutController($this->_page, $this->_method);
                break;
            case "feed":
                $this->_controller = new FeedController($this->_page, $this->_method);
                break;
            case "profile":
                $this->_controller = new ProfileController($this->_page, $this->_method);
                break;
            case "deletePost":
                $this->_controller = new DeletePostController($this->_page, $this->_method);
                break;
            case "userOptions":
                $this->_controller = new UserOptionsController($this->_page, $this->_method);
                break;
            case "updateAccountStatus":
                $this->_controller = new UpdateUserStatusController($this->_page, $this->_method);
                break;
            case "resendMail":
                $this->_controller = new ResendMailController($this->_page, $this->_method);
                break;
            case "deleteAccount":
                $this->_controller = new DeleteUserController($this->_page, $this->_method);
                break;
            default:
                $this->_controller = new HTTPResponseController($this->_page, $this->_method);
                break;
        }
    }
}