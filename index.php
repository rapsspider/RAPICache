<?php

define('__APP_ROOT__', __DIR__);

require 'vendor/autoload.php';

include 'config.php';
include 'routes.php';

$url = isset($_GET['_url']) ? $_GET['_url'] : '/';

$view = RAPICache\Router::route($url);

echo $view;