<?php

namespace HTTPResponses;

class HTTPResponseController {
    private string $_page;
    private string $_method;
    private $_error;

    public function __construct($page, $method){

        $this->_page = $page;
        $this->_method = $method;

        require_once '../Views/404.php';
    }
}