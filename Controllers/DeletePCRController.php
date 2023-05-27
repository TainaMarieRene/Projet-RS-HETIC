<?php

namespace DeletePCRController;

// Models
use Posts\Post;
// Src
require_once '../src/Helpers.php';
use Helpers\Helpers;

class DeletePCRController {
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private Post $_modelPost;

    public function __construct($page, $method){
        require_once '../Models/Posts.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_modelPost = new Post();

        $delete_type = filter_input(INPUT_GET, 'delete_type');
        $delete_id = filter_input(INPUT_GET, 'delete_id');

        $this->_modelPost->deletePCR($delete_type, $delete_id, $_COOKIE['uniCookieUserID']);

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}