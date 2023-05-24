<?php

namespace ProfileController;

// Models
use Profiles\Profile;

// Src
require_once '../src/Helpers.php';
use Helpers\Helpers;

class ProfileController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private Profile $_modelProfile;

    public function __construct($page, $method){
        require_once '../Models/Profiles.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_modelProfile = new Profile();

        $profile = $this->_modelProfile->getProfileInfo($_COOKIE['uniCookieUserID']);

        require_once '../Views/profile2.php';
    }
}