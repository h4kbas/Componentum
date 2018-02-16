<?php

use RedBeanPHP\R as DB,
    Just\Core\Session;

if(session_id() === ""){
    session_start();
}
if (DEBUG) {
	$whoops = new \Whoops\Run;
	$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
    $whoops->register();
    error_reporting(E_ALL);
    ini_set('display_errors','On');
}
else{
    error_reporting(E_ALL);
    ini_set('display_errors','Off');
    ini_set('log_errors', 'On');
    ini_set('error_log', 'tmp/logs/error.log');
}
DB::ext('prep', function( $type ){ 
    return DB::getRedBean()->dispense( $type ); 
});
DB::setup( 'mysql:host='.DB_HOST.';port='.DB_PORT.';dbname='.DB_NAME, DB_USER, DB_PASSWORD );

if(!Session::has("lang"))
    Session::set("lang", substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));

require_once 'router.php';