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

/*
	Inversion of control
*/
class IoC {

	private static $registry = array();

	private static $instances = array();
	
	public static function bootstrap() {
		static::$registry = Config::get('container', array());
	}

	public static function register($name, $resolver, $singleton = false) {
		static::$registry[$name] = array('resolver' => $resolver, 'singleton' => $singleton);
	}
	
	public static function instance($name, $instance) {
		static::$instances[$name] = $instance;
	}

	public static function resolve($name) {
		if(isset(static::$instances[$name])) {
			return static::$instances[$name];
		}
		
		if(isset(static::$registry[$name])) {
			$object = call_user_func(static::$registry[$name]['resolver']);
			
			if(isset(static::$registry[$name]['singleton']) and static::$registry[$name]['singleton']) {
				static::$instances[$name] = $object;
			}

			return $object;
		}
		
		return false;
	}
}

/* End of file */
