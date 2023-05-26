<?php

namespace FriendController;

use Friends\Friend;

class FriendController {
    private Friend $_modelFriend;
    private string $_method;
    private string $_page;
    private int $_user_id1;
    private string $_token;
    private string $_user_id2;
    private array $_friends;
    private array $_friends_request;
    private array $_friends_requesting;
    private array $_blocked;

    public function __construct($_page, $_method){
        require_once '../Models/Friends.php';
        $this->_page = $_page;
        var_dump($this->_page);
        $this->_method = $_method;
        $this->_modelFriend = new Friend();
        $this->_user_id1 = $_COOKIE['uniCookieUserID'];
        $this->_token = $_COOKIE['uniCookieUserID'];
        $this->_friends = $this->_modelFriend->get_friend_by_relation($this->_user_id1, 'friend');
        $this->_friends_request = $this->_modelFriend->get_friend_request($this->_user_id1);
        $this->_friends_requesting = $this->_modelFriend->get_friend_requesting($this->_user_id1);
        $this->_blocked = $this->_modelFriend->get_blocked($this->_user_id1);
        require_once '../Views/friends.php';
        switch ($this->_method) {
            case 'POST':
                switch ($this->_page) {
                    case 'addFriend':
                        $this->_user_id2 = filter_input(INPUT_POST, 'user_id2');
                        $this->_modelFriend->add_friends($this->_user_id1, $this->_user_id2);
                        header('Location: index.php?p=friends');
                        break;
                    case 'acceptFriend':
                        $this->_user_id2 = filter_input(INPUT_POST, 'user_id2');
                        $this->_modelFriend->accept_friend($this->_user_id1, $this->_user_id2);
                        header('Location: index.php?p=friends');
                        break;
                    case 'blockFriend':
                        $this->_user_id2 = filter_input(INPUT_POST, 'user_id2');
                        $this->_modelFriend->block_friend($this->_user_id1, $this->_user_id2);
                        header('Location: index.php?p=friends');
                        break;
                    case 'unblockFriend':
                        $this->_user_id2 = filter_input(INPUT_POST, 'user_id2');
                        $this->_modelFriend->unblock_friend($this->_user_id1, $this->_user_id2);
                        header('Location: index.php?p=friends');
                        break;
                    case 'deleteFriend':
                        $this->_user_id2 = filter_input(INPUT_POST, 'user_id2');
                        $this->_modelFriend->delete_friend($this->_user_id1, $this->_user_id2);
                        header('Location: index.php?p=friends');
                        break;
                }
                break;
        }
    }
}

