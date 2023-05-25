<?php

namespace PostController;

// Models
use Posts\Post;
// Src
require_once '../src/Helpers.php';
use Helpers\Helpers;

class DeletePostController {
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

        $post_id = filter_input(INPUT_GET, 'post_id');
        $user_id = $_COOKIE['uniCookieUserID'];

        $post_img = $this->_modelPost->deletePost($post_id, $user_id);
        if(!$this->_modelPost->imgIsUse($post_img)){
            unlink("../Views/assets/imgs/users/posts/" . $post_img);
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}