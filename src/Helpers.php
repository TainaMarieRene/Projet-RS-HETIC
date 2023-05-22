<?php

namespace Helpers;

require_once '../Models/Authentifications.php';
require_once '../Models/Users.php';
use Authentifications\Authentification;
use Users\User;

class Helpers{
    private string $_page;
    private string $_uniCookieUserID;
    private string $_uniCookieAgent;
    private string $_uniCookieToken;
    private Authentification $_modelAuth;
    private User $_modelUser;

    public function __construct($page, $uniCookieUserID, $uniCookieAgent, $uniCookieToken){
        $this->_page = $page;
        $this->_uniCookieUserID = $uniCookieUserID;
        $this->_uniCookieAgent = $uniCookieAgent;
        $this->_uniCookieToken = $uniCookieToken;
        $this->_modelAuth = new Authentification();
        $this->_modelUser = new User();

        switch ($this->_page){
            case "login":
                if($this->_modelAuth->areLogin($this->_uniCookieUserID, $this->_uniCookieAgent, $this->_uniCookieToken)){
                    header("Location: index.php?p=feed");
                    exit();
                }
                break;
            case "register":
                if($this->_modelAuth->areLogin($this->_uniCookieUserID, $this->_uniCookieAgent, $this->_uniCookieToken)){
                    header("Location: index.php?p=feed");
                    exit();
                }
                break;
            default:
                if(!$this->_modelAuth->areLogin($this->_uniCookieUserID, $this->_uniCookieAgent, $this->_uniCookieToken)){
                    header("Location: index.php");
                    exit();
                } else {
                    $this->_modelUser->updateLastSeen($this->_uniCookieUserID);
                }
                break;
        }
    }
}