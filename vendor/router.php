<?php

use Just\Core\Map,
    Just\Core\Route;

$_JUST['url_array'] =  explode("/", $_JUST['url']);
$_JUST['method'] = strtolower($_SERVER['REQUEST_METHOD']);

if($_JUST['url'] == '/'){
    $_JUST['controller'] = 'Home';
    $_JUST['action'] = 'Index';
}
else if(count($_JUST['url_array'] ) == 1){
    $_JUST['controller'] = ucwords($_JUST['url_array'][0]);
    $_JUST['action'] = 'Index';
}
else{
    $_JUST['controller'] = ucwords($_JUST['url_array'][0]);
    array_shift($_JUST['url_array']);
    $_JUST['action'] = ucwords($_JUST['url_array'][0]);
    array_shift($_JUST['url_array']);
    $_JUST['params'] = $_JUST['url_array'];
}

$_JUST['map'] = new Map($_JUST);

if(is_callable([$_JUST['map']->plugin, $_JUST['method'].$_JUST['map']->action])){
    $result = true;
    if(isset($_JUST['map']->map['filter'])){
        foreach($_JUST['map']->map['filter'] as $f => $acs){
            if($acs[0] == "*" || 
                (
                    (isset($acs[0]['only']) && in_array($_JUST['map']->action, $acs[0]['only'])) 
                        || 
                    (isset($acs[0]['except']) && !in_array($_JUST['map']->action, $acs[0]['except'])) 
                )
            ){
                $f = explode('/', $f);
                $fname = "Plugins\\{$f[0]}\\Filters\\{$f[1]}";
                $filter = new $fname($acs, $_JUST['map']->plugin);
                if($r = $filter->handle())
                    $result = $result && $r;
                else{
                    $filter->fallback();
                    exit;
                }
            }
        }
    }
    if($result)
        call_user_func_array([$_JUST['map']->plugin,  $_JUST['method'].$_JUST['map']->action], isset($_JUST['params']) ? $_JUST['params'] : []);
}
else
    Route::abort(404);