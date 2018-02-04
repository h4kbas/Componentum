<?php namespace Plugins\Auth\Filters;

use Just\Core\Filter;

class User extends Filter {
    
    function handle(){
        return false;
    }

    function fallback(){
        echo "Hatalı";
    }
}