<?php
require ('../Models/Database.php');
require ('../Controllers/PostPageController.php');

use Post\PostPageController;

$postPageController = new PostPageController();

$postData = $postPageController->renderData();
var_dump($postData);