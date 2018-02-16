<?php namespace Just\Util;

use RedBeanPHP\R as DB;

class Query {
    private $query = [];

    public function __construct($table){
        $this->query['table'] = $table;   
    }
    public function select($items = '*'){
        if(is_array($items)){
            foreach($items as $i){
                $this->query['select'] []= $i;
            }
        }
        else    
            $this->query['select'] []= $items;
        return $this;
    }	

    public function limit($start = null, $length = null){
        $this->query['limit'] = [$start, $length];
        return $this;
    }	

    public function orderBy($by, $dir = "asc"){
        $this->query['orderby'] = [$by, $dir];
        return $this;
    }	

    public function where($col, $op, $dir, $and = true){
        $this->query['where'] []= [$col, $op, $dir, $and];
        return $this;
    }

    public function take(){
        $fields = [];
        $select = "*";
        if(isset($this->query['select'])){
            $select = implode(',', $this->query['select']);
        }
        $where = "";
        if(isset($this->query['where'])){
            $where = "WHERE ";
            foreach($this->query['where'] as $k => $w){
                $where .= "{$w[0]} {$w[1]} ?"; $fields [] = $w[2];
                if($k < count($this->query['where']) - 1)
                    if($w[3]) $where .= " AND ";
                    else $where .= " OR ";
            }
        }
        $orderby = "";
        if(isset($this->query['orderby'])){
            $orderby = "ORDER BY {$this->query['orderby'][0]} {$this->query['orderby'][1]}";
        }
        $limit = "";
        if(isset($this->query['limit'])){
            if($this->query['limit'][0]){
                $limit = "LIMIT ?"; $fields [] = intval($this->query['limit'][0]);
            }
            if($this->query['limit'][1]){
                $limit .= ", ?"; $fields [] = intval($this->query['limit'][1]);
            }
        }
        $items = DB::getAll("SELECT $select FROM {$this->query['table']} $where $orderby $limit", $fields);
        return count($items) == 1 ? $items[0] : $items;
    }
}
