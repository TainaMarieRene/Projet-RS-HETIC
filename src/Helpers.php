<?php

namespace Helpers;

require_once '../Models/Authentifications.php';
use Authentifications\Authentification;

class Helpers{
    private string $_page;
    private string $_uniCookieUsername;
    private string $_uniCookieAgent;
    private string $_uniCookieToken;
    private Authentification $_modelAuth;

    public function __construct($page, $uniCookieUsername = '', $uniCookieAgent = '', $uniCookieToken = ''){
        $this->_page = $page;
        $this->_uniCookieUsername = $uniCookieUsername;
        $this->_uniCookieAgent = $uniCookieAgent;
        $this->_uniCookieToken = $uniCookieToken;
        $this->_modelAuth = new Authentification();

        switch ($this->_page){
            case "login":
                if($this->_modelAuth->areLogin($uniCookieUsername, $uniCookieAgent, $uniCookieToken)){
                    header("Location: index.php?p=feed");
                    exit();
                }
                break;
            case "register":
                if($this->_modelAuth->areLogin($uniCookieUsername, $uniCookieAgent, $uniCookieToken)){
                    header("Location: index.php?p=feed");
                    exit();
                }
                break;
            default:
                if(!$this->_modelAuth->areLogin($uniCookieUsername, $uniCookieAgent, $uniCookieToken)){
                    header("Location: index.php");
                    exit();
                }
                break;
        }
    }
}