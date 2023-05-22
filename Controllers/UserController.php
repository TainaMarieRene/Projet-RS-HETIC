<?php

namespace UserController;

use Users\User;
use Profiles\Profile;
use Authentifications\Authentification;
require_once '../src/Helpers.php';
use Helpers\Helpers;

class UserOptionsController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private User $_modelUser;
    private array $_user;
    private $_error;

    public function __construct($page, $method){
        require_once '../Models/Users.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUsername']) ? $_COOKIE['uniCookieUsername'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '', isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '');
        $this->_modelUser = new User();

        $this->_user = $this->_modelUser->getUserByID($_COOKIE['uniCookieUserID']);

        require_once '../Views/userOptions.php';
        if($this->_error){ return $this->_error; }
    }
}

class UpdateUserStatusController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private string $_type;
    private User $_modelUser;

    public function __construct($page, $method){
        require_once '../Models/Users.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUsername']) ? $_COOKIE['uniCookieUsername'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '', isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '');
        $this->_type = preg_match("`^(valid|disable)$`", filter_input(INPUT_GET, "type")) ? filter_input(INPUT_GET, "type") : '';
        $this->_modelUser = new User();

        $this->_modelUser->updateStatus($_COOKIE['uniCookieUserID'], $this->_type);

        header("Location: index.php?p=userOptions");
        exit;
    }
}

class DeleteUserController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private User $_modelUser;
    private Profile $_modelProfile;
    private Authentification $_modelAuth;

    public function __construct($page, $method){
        require_once '../Models/Users.php';
        require_once '../Models/Profiles.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUsername']) ? $_COOKIE['uniCookieUsername'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '', isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '');
        $this->_modelUser = new User();
        $this->_modelProfile = new Profile();
        $this->_modelAuth = new Authentification();

        $this->_modelProfile->deleteProfile($_COOKIE['uniCookieUserID']);
        $this->_modelUser->deleteUser($_COOKIE['uniCookieUserID']);
        header("Location: index.php?p=logout&type=allDevice");
        exit;
    }
}