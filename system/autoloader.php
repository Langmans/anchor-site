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

class Autoloader {

	private static $aliases = array();

	/*
	 * Installs this class loader on the SPL autoload stack.
	 */
	public static function register() {
		spl_autoload_register(array(__NAMESPACE__ .'\Autoloader', 'load'));
	}

	/*
	 * Uninstalls this class loader from the SPL autoloader stack.
	 */
	public static function unregister() {
		spl_autoload_unregister(array(__NAMESPACE__ .'\Autoloader', 'load'));
	}

	public static function load($class) {

		$file = str_replace(array('//', '\\'), DIRECTORY_SEPARATOR, trim(strtolower($class), DIRECTORY_SEPARATOR));

		// load aliases
		if(empty(static::$aliases)) {
			static::$aliases = Config::get('aliases');
		}

		// find alias
		if(array_key_exists($class, static::$aliases)) {
			return class_alias(static::$aliases[$class], $class);
		}
		
		// get file path
		if(($path = static::find($file)) === false) {
			return false;
		}

		require $path;

		return true;
	}
	
	public static function find($file) {
		// search system and application paths
		foreach(array(BASE_PATH, SYS_PATH, APP_PATH . 'library/', APP_PATH . 'models/', APP_PATH . 'controllers/') as $path) {
			if(stream_resolve_include_path($path . $file . EXT)) {
				return $path . $file . EXT;
			}
		}
		
		return false;
	}

}

/* End of file */
