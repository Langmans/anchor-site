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

class Str {

	/**
	 * Convert HTML characters to entities.
	 *
	 * @param string $value
	 * @return string
	 */
	public static function entities($value) {
		return htmlentities($value, ENT_QUOTES, Config::get('application.charset'), false);
	}

	/**
	 * Convert a string to lowercase.
	 *
	 * @param string $value
	 * @return string
	 */
	public static function lower($value) {
		return function_exists('mb_strtolower') ? mb_strtolower($value, Config::get('application.charset')) : strtolower($value);
	}

	/**
	 * Convert a string to uppercase.
	 *
	 * @param string $value
	 * @return string
	 */
	public static function upper($value) {
		return function_exists('mb_strtoupper') ? mb_strtoupper($value, Config::get('application.charset')) : strtoupper($value);
	}

	/**
	 * Convert a string to title case (ucwords).
	 *
	 * @param string $value
	 * @return string
	 */
	public static function title($value) {
		return function_exists('mb_convert_case') ? mb_convert_case($value, MB_CASE_TITLE, Config::get('application.charset')) : ucwords(strtolower($value));
	}

	/**
	 * Generate a random alpha-numeric string.
	 *
	 * @param int $length
	 * @return string
	 */
	public static function random($length = 16) {
		$pool = str_split('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', 1);
		$value = '';

		for ($i = 0; $i < $length; $i++)  {
			$value .= $pool[mt_rand(0, 61)];
		}

		return $value;
	}

	/**
	 * Truncate a sentence by words
	 *
	 * @param string $str
	 * @param int $limit
	 * @param string $elipse
	 * @return string
	 */
	public static function truncate($str, $limit = 10, $elipse = ' [...]') {
		$words = preg_split('/\s+/', $str);

		if(count($words) <= $limit) {
			return $str;
		}

		return implode(' ', array_slice($words, 0, $limit)) . $elipse;
	}

}

/* End of file */