<?php namespace Plugins\Admin\Filters;

use Just\Core\Filter,
    Just\Core\Session;
class Admin extends Filter {
    
    function handle(){
       return Session::has($this->plugin->table);
    }

    function fallback(){
        $this->plugin->redirect($this->use('fallback') ?: '/', false);
    }
}