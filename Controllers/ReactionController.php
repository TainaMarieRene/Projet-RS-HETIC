<?php 

namespace ReactionController;

// Models
use Reactions\Reaction;
// Src
require_once '../src/Helpers.php';
use Helpers\Helpers;

class ReactController{
    private string $_page;
    private string $_method;
    private Helpers $_helpers;
    private Reaction $_modelReaction;
    private $_error;

    public function __construct($page, $method){
        require_once '../Models/Reactions.php';

        $this->_page = $page;
        $this->_method = $method;
        $this->_helpers = new Helpers($page, isset($_COOKIE['uniCookieUserID']) ? $_COOKIE['uniCookieUserID'] : '', isset($_COOKIE['uniCookieAgent']) ? $_COOKIE['uniCookieAgent'] : '', isset($_COOKIE['uniCookieToken']) ? $_COOKIE['uniCookieToken'] : '');
        $this->_modelReaction = new Reaction();

        $reaction_type = preg_match("`^(post|comment)$`", filter_input(INPUT_GET, "reaction_type"))? filter_input(INPUT_GET, "reaction_type") : false;
        $reaction_type_id = filter_input(INPUT_GET, "reaction_type_id");
        $reaction_emoji = preg_match("`^(like|celebrate|love|insightful|curious)$`", filter_input(INPUT_GET, "reaction_emoji"))? filter_input(INPUT_GET, "reaction_emoji") : false;
        
        if($reaction_type && $reaction_type_id && $reaction_emoji){
            $this->_modelReaction->managReaction($reaction_type, $reaction_type_id, $_COOKIE['uniCookieUserID'], $reaction_emoji);
        }

        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}