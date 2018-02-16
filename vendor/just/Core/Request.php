<?php namespace Just\Core;

use RedBeanPHP\R as DB;

class Request{

	static function get($t) {
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET': return $_GET[$t]; break;
			case 'POST': return $_POST[$t]; break;
		}
	}

	static function getIfExists($t){
		if(self::has($t))
			return self::get($t);
		else
			return null;
	}

	static function has($t){
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET': return array_key_exists($t, $_GET); break;
			case 'POST': return  array_key_exists($t, $_POST); break;
		}
	}

	static function raw(){
		return file_get_contents("php://input");
	}

	static function file($t) {
		return $_FILES[$t];
	}

	static function all() {
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET': return $_GET; break;
			case 'POST': return $_POST; break;
		}
	}

	static function only($k){
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET': return array_intersect($k, $_GET); break;
			case 'POST': return array_intersect($k, $_POST); break;
		}
	}
	static function except($k){
		switch($_SERVER['REQUEST_METHOD'])
		{
			case 'GET': return array_diff($_GET, $k); break;
			case 'POST': return array_diff($_POST, $k); break;
		}
	}

	static function fill($table, $fields, $def, $checkreq = true){
		foreach($fields as $r => $v){
			if(isset($v['protected']) && $v['protected']){
				continue;
			}

			if(isset($v['default'])){
				$def[$r] = $v['default'];
			}

			if(isset($v['unique']) && $v['unique']){
				if(DB::findOne($table, "$r = ?", [self::get($r)]))
					throw new \Exception('uniquefields');
			}
			
			if($checkreq && isset($v['required']) && $v['required']){
				if((self::has($r) && self::get($r) != '') || isset($_FILES[$r])){
					if(!self::processfill($r, $v, $def))
					throw new \Exception('emptyfields');
				}
				else
					throw new \Exception('emptyfields');
			}
			else if(self::has($r) || isset($_FILES[$r]))
				if(!self::processfill($r, $v, $def))
					throw new \Exception('emptyfields');
		}
		return $def;
	}

	private static function processfill($r, $v, $def){
		if($v['type'] == 'File'){
			$handle = new \upload($_FILES[$r]);
			if ($handle->uploaded) {
				$dir = $v['upload']['dir'];
				unset($v['upload']['dir']);
				foreach($v['upload'] as $key => $u){
					$handle->$key = $u;
				}
				$handle->process($dir);
				if ($handle->processed) {
					if($handle->file_dst_pathname)
						$def[$r] = $handle->file_dst_pathname;
					else
						return false;
					$handle->clean();
				}
				else 
					return false;
			}
		}
		else if($v['type'] == 'Checkbox'){
			$def[$r] = self::get($r) == 'on';
		}
		else{
			$def[$r] = self::get($r);
		}
		return true;
	}

}
