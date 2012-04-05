<?php

class Notifications {

	private static $sess_name = 'notifications';
	
	public static function add($type, $message) {
		$arr = Session::get(static::$sess_name, array());
		
		if(!is_array($message)) {
			$message = array($message);
		}
		
		if(!isset($arr[$type])) {
			$arr[$type] = array();
		}
		
		$arr[$type] = array_merge($arr[$type], $message);
		
		Session::set(static::$sess_name, $arr);
	}
	
	public static function read() {
		$arr = Session::get(static::$sess_name, array());
		$html = '';
		
		foreach($arr as $type => $messages) {
			$html .= '<p class="notification ' . $type . '">' . implode('<br />', $messages) . '</p>' . PHP_EOL;
		}
		
		Session::forget(static::$sess_name);
		
		return $html;
	}	
	
}

