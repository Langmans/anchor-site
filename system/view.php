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

class View {

	/**
	 * Template variables
	 */
	private static $data = array();
	
	/**
	 * Output buffer nesting level
	 */
	private static $ob_level;

	/**
	 * Include template and get output
	 */
	public static function make($view, $data = array()) {
		// does the view exist?
		if(file_exists(APP_PATH . 'views' . DIRECTORY_SEPARATOR . $view . EXT) === false) {
			throw new \Exception('View not found "' . $view . '"');
		}

		// set output buffer level
		static::$ob_level = ob_get_level();

		// merge variables to allow access for nested templates
		static::$data = array_merge(static::$data, $data);

		// start output buffer
		ob_start();

		// create template variables
		extract(static::$data);

		// execute template file
		require APP_PATH . 'views/' . $view . EXT;

		// check nesting level
		if(ob_get_level() > static::$ob_level) {
			// output buffer stack
			ob_end_flush();
		} else {
			// append to response
			Response::append(ob_get_contents());
			
			// Clean (erase) the output buffer and turn off output buffering
			ob_end_clean();
		}
	}

}

/* End of file */