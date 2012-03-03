<?php namespace System;

/**
 * PeachyPhp
 *
 * Just another PHP Framework
 *
 * @package		peachy-php
 * @author		k. wilson
 * @link		http://peachy-php.co.uk
 */

class Browser {

	public static function is_mobile() {
		if(preg_match('/(up.browser|up.link|mmp|symbian|smartphone|midp|wap|phone|android)/i', static::ua())) {
			return true;
		}

		return false;
	}

	public static function ua() {
		return Input::user_agent();
	}
	
	public static function platform() {
		if(preg_match('/ip(?:ad|od|hone)/i', static::ua(), $matches)) {
			return $matches[0];
		}

		if(preg_match('/(?:webos|android)/i', static::ua(), $matches)) {
			return $matches[0];
		}
		
		
		if(preg_match('/(mac|win|linux)/i', static::ua(), $matches)) {
			return $matches[0];
		}
		
		return 'other';
	}
	
	public static function engine() {
		if(preg_match('/(?:webkit|khtml|gecko)/i', static::ua(), $matches)) {
			return $matches[0];
		}
		
		return 'other';
	}

}

/* End of file */
