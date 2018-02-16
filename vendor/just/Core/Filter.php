<?php namespace Just\Core;

class Filter {

    public function use($u){
        if(isset($this->uses) && isset($this->uses[strtolower($u)])){
            return $this->uses[strtolower($u)];
        }
        else
            return null;
    }
    public function __construct($acs, $plugin){
        $this->plugin = $plugin;
        $this->uses = isset($acs[1]) ? $acs[1] : [];
    }
}