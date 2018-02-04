<?php namespace Just\Core;

use RedBeanPHP\R as DB;
use Just\Util\Query;
class Plugin{
    public $models;

    public function error($lang, $ex){
        Session::flash('@error', $this->lang($lang, $ex->getMessage()));
    }
    
    public function success($lang, $ex){
        Session::flash('@success', $this->lang($lang, $ex));
    }

    public function url($x){
        if(isset($this->map['map'])){
            if($f = array_search(ucwords($x), $this->map['map']))
                return "/{$this->controller}/$f";
        }
        return "/{$this->controller}/$x";   
    }
    public function redirect($x){
        return Route::redirect($this->url($x));
    }

    public function translate($v){
        if(substr($v, 0, 1) == '@'){
            $t = explode("/", substr($v, 1));
            return $this->lang($t[0], $t[1]);
        }
    }
    private function processModel($model, $rel = false){
        foreach($model as $r => &$v){
            if(isset($v['title'])){
                $v['title'] = $this->translate($v['title']);
            }
            if($rel && isset($v['relation'])){
                $select = $v['resolve']['display'].','.$v['resolve']['return'];
                if(isset($this->map['use']) && isset($this->map['use'][strtolower($v['relation']['table'])]))
                $v['relation']['table'] = strtolower($this->map['use'][strtolower($v['relation']['table'])]).'_'.$v['relation']['table'];
				$v['resolve']['sequence'] = DB::getAll("Select $select  From {$v['relation']['table']}");
			}
        }
        return $model;
    }

    public function model($m, $rel = false){
        if(isset($this->models[$m])) 
            return $this->models[$m]; 
        $model = "{$this->path}/Models/$m.php";
        if(file_exists($model)){
            $this->models[$m] = require_once $model;
            return $this->processModel($this->models[$m], $rel);
        }
        else
            throw new \Exception('Model Not Found');
    }

    public function createFromRequest($m){
        $ex = [];
        $model = $this->model($m);
        foreach($model as $k => &$d){
            if(isset($d['update']) && !$d['update']){
                $ex[$k] = '';
            }
            if(isset($d['protected']) && $d['protected']){
                $ex[$k] = '';
			}
        }
        if($ret = Request::fill( array_diff_key($model, $ex), DB::prep($this->table)))
            return DB::store($ret);
        else
            throw new \Exception('emptyfields');
    }

    public function updateFromRequest($m, $id){
        if($def = DB::findOne($this->table, 'id = ?', [$id])){
            $ex = [];
            $model = $this->model($m);
            foreach($model as $k => &$d){
                if(isset($d['update']) && !$d['update']){
                    $ex[$k] = '';
                }
                if(isset($d['protected']) && $d['protected']){
                    $ex[$k] = '';
                }
            }
            if($ret = Request::fill( array_diff_key($model, $ex), $def, false))
                return DB::store($ret);
            else
                throw new \Exception('emptyfields');
        }
        else
            throw new \Exception('notfound');
    }

    public function deleteById($id){
        if($item = DB::findOne($this->table, 'id = ?', [$id])){
            DB::trash($item);
        }
        else
            throw new \Exception('notfound');
    }

    public function findById($id){
        return DB::findOne($this->table, 'id = ?', [$id]);
    }

    public function query(){
        return new Query($this->table);
    }
    
    public function lang($m, $g){
        $m = strtolower($m);
        $g = strtolower($g);
        if(!isset($this->langs[$m])){
            $lang = "{$this->path}/Langs/".ucwords(Session::get('lang'))."/".ucwords($m).".php";
            if(file_exists($lang))
            $this->langs[$m] = require_once $lang;
            else
                throw new \Exception('Lang Not Found');
        } 
        if(isset($this->langs[$m][$g]))
            return $this->langs[$m][$g];
        else
            return "$m.$g";
    }

    public function __construct($c, $a, $map){
        $this->table = strtolower($c).'_'.$this::tablesuffix;
        $this->controller = $c;
        $this->action = $a;
        $this->map = $map;
        $this->template = new Template($c);

        $path = explode("\\", get_class($this));
        $path = $path[count($path) - 2];
        $this->path = ROOT."/plugins/".$path;
    }
}
