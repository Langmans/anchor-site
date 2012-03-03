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

class Session {

	private static $session, $driver;
	
	private static function driver() {
		if(is_null(static::$driver)) {
			switch(Config::get('session.driver')) {
				case 'cookie':
					return static::$driver = new Session\Cookie;
					break;
				case 'db':
					return static::$driver = new Session\Db;
					break;
				case 'memcache':
					return static::$driver = new Session\Memcache;
					break;
				case 'mongo':
					return static::$driver = new Session\Mongo;
					break;
				default:
					throw new \ErrorException('Session driver [' . Config::get('session.driver') . '] is not supported.');
			}
		}
		
		return static::$driver;
	}

	public static function read($id) {
		if($id) {
			static::$session = static::driver()->read($id);
		}

		if(is_null(static::$session) or static::$session === false) {
			static::$session = array('id' => Str::random(40), 'last_activity' => date("c"), 'data' => array());
		}
	}

	public static function write() {
		static::$session['last_activity'] = date("c");
		static::driver()->write(static::$session);
		Cookie::write('session', static::$session['id'], time() + Config::get('session.expire'), Config::get('session.path'), Config::get('session.domain'));
	}

	public static function get($key = null, $default = false) {
		if(is_null($key)) {
			return static::$session['data'];
		}

		if(array_key_exists($key, static::$session['data'])) {
			return static::$session['data'][$key];
		}

		return ($default instanceof \Closure) ? call_user_func($default) : $default;
	}

	public static function set($key, $value) {
		static::$session['data'][$key] = $value;
	}

	public static function forget($key) {
		unset(static::$session['data'][$key]);
	}

	public static function has($key) {
		return isset(static::$session['data'][$key]);
	}

}

/* End of file */