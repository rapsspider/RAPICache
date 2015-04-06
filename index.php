<?php

define('__APP_ROOT__', __DIR__);

require_once 'src/ApiLOL/Config.php';
require_once 'src/ApiLOL/View.php';
require_once 'src/ApiLOL/Cache.php';
require_once 'src/ApiLOL/Router.php';

include 'routes.php';
include 'config.php';

$url = isset($_GET['_url']) ? $_GET['_url'] : '/';

$view = ApiLOL\Router::route($url);

echo $view->body;