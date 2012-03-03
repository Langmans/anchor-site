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

class Csv {

	private static $fp; // file pointer

	/*
	 *	For portability, it is strongly recommended
	 *	that you always use the 'b' flag
	 */
	public static function open($file, $mode = 'rb') {
		if((static::$fp = @fopen($file, $mode)) === false) {
			return false;
		}
	}

	public static function close() {
		return fclose(static::$fp);
	}

	public static function put($data, $delimiter = ',', $enclosure = '"') {
		// must be an array of cells
		if(!is_array($data)) {
			$data = array($data);
		}

		return fputcsv(static::$fp, $data, $delimiter, $enclosure);
	}

	public static function get($delimiter = ',', $enclosure = '"', $escape = '\\') {
		return fgetcsv(static::$fp, 0, $delimiter, $enclosure, $escape);
	}

}

/* End of file */