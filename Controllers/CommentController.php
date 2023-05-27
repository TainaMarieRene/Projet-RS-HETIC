<?php 

namespace CommentController;

// Models
use Comments\Comment;
// Src
require_once '../src/Helpers.php';
use Helpers\Helpers;

class DeleteCommentController{
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private Comment $_modelComment;
    private $_error;

    public function __construct($page, $method){
        require_once '../Models/Comments.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_modelComment = new Comment();

        $post_comment_id = filter_input(INPUT_GET, "comment_id", FILTER_VALIDATE_INT);
        
        if($post_comment_id){
            $this->_modelComment->deleteComment($post_comment_id, $_COOKIE['uniCookieUserID']);
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}