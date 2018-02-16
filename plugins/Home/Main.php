<?php namespace Plugins\Home;

use Just\Core\Plugin,
    Just\Core\Route;

class Main extends Plugin{
    const tablesuffix = "home";

    public function getIndex(){  
        $this->template->render($this->use('homepage') ?: 'Homepage');
    }
}