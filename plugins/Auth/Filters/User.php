<?php namespace Plugins\Auth\Filters;

use Just\Core\Filter;

class User extends Filter {
    
    function handle(){
        return Session::has($this->plugin->table);
    }

    function fallback(){
        $this->plugin->redirect($this->use('fallback') ?: '/', false);
    }
}