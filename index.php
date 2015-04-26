<?php

define('__APP_ROOT__', __DIR__);

require 'vendor/autoload.php';

include 'app/config.php';
include 'app/routes.php';

$url = isset($_GET['_url']) ? $_GET['_url'] : '/';

$view = RAPICache\Router::route($url);

echo $view;