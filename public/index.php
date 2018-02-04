<?php

require_once '../vendor/autoload.php';


$_JUST['url'] = (!empty($_GET['url'])) ? $_GET['url'] :'/';

define('ROOT', dirname(dirname(__FILE__)));
define('VIEWS', '../views');

require_once '../config.php';
require_once '../vendor/bootstrap.php';