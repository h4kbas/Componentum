<?php namespace Just\Core;
class Route{

	static function redirect($url) {
		return header("Location: $url");
	}

	static function back() {
		header("Location: {$_SERVER['HTTP_REFERER']}");
		exit;
	}

	static function abort($what){
		http_response_code($what);
		die();
	}

}
