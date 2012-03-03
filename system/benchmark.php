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

class Benchmark {

	public static $marks = array();

	public static function start($name) {
		static::$marks[$name] = microtime(true);
	}

	public static function check($name, $precision = 2) {
		if (array_key_exists($name, static::$marks)) {
			return round((microtime(true) - static::$marks[$name]) * 1000, $precision);
		}

		return 0.0;
	}

	public static function memory() {
		return round(memory_get_usage() / 1024 / 1024, 2);
	}

}

/* End of file */
