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

class Config {

	private static $items = array();
	private static $mapped = array();
	
	public static function get($key, $default = false) {
		$parts = explode('.', $key);
		$items = static::$items;
		$index = 0;
		
		while(isset($items[$parts[$index]])) {
			$items = $items[$parts[$index]];
			$index++;

			if(!isset($parts[$index])) {
				return $items;
			}
		}

		return $default;
	}

	public static function load($file) {
		if(in_array($file, static::$mapped)) {
			return true;
		}
		
		$path = APP_PATH . 'config/' . $file . EXT;

		if(file_exists($path) === false) {
			throw new \Exception('Config file not found "' . $file . '"');
		}

		// add file to mapped files
		static::$mapped[] = $file;

		// get returned array
		static::$items[$file] = require $path;
	}

}

/* End of file */
