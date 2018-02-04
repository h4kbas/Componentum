<?php namespace Just\Core;

use Just\Core\Route;

class Map {

    public $plugin;
    public $action;
    public function __construct($_JUST){
        if(file_exists(ROOT."/maps/{$_JUST['controller']}.php")){
            $this->controller = $_JUST['controller'];
            $this->action = $_JUST['action'];
            $this->map = require_once ROOT."/maps/{$_JUST['controller']}.php";    
            $this->process();
        }
        else
            Route::abort(500);
    }
    public function process(){
        if(isset($this->map['is'])){
            $p = "Plugins\\{$this->map['is']}\\Main";
            $this->plugin = new $p($this->controller, $this->action, $this->map);
        }

        if(isset($this->map['map'])){
            if(isset($this->map['map'][$this->action]))
                $this->action = $this->map['map'][$this->action];
            else{
                if($other = array_search($this->action, $this->map['map']))
                    Route::abort(404);
            }
        }
    }
}