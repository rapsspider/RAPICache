<?php

define('__APP_ROOT__', __DIR__);

require_once 'src/RAPICache/Config.php';
require_once 'src/RAPICache/View.php';
require_once 'src/RAPICache/Cache.php';
require_once 'src/RAPICache/Route.php';
require_once 'src/RAPICache/Router.php';

include 'config.php';
include 'routes.php';

$url = isset($_GET['_url']) ? $_GET['_url'] : '/';

$view = RAPICache\Router::route($url);

echo $view->body;