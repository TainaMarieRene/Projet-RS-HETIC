<?php

session_start();

// Call the router
require '../src/Router.php';
use Router\Router;
$router = new Router();