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

class Request {

	public static function uri() {
		/**
		 * Running in command line
		 * Note: only available when register_argc_argv is enabled.
		 *
		 * Usage: /path/to/file/index.php controller method ID
		 */
		if(isset($_SERVER['argc']) and isset($_SERVER['argv'])) {
			// remove script path
			array_shift($_SERVER['argv']);
			$uri = implode('/', $_SERVER['argv']);
		}
		// Use Path_info
		elseif(isset($_SERVER['PATH_INFO'])) {
			$uri = $_SERVER['PATH_INFO'];
		}
		// try request uri
		elseif(isset($_SERVER['REQUEST_URI'])) {
			// make sure we can parse URI
			if(($uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH)) === false) {
				throw new \Exception('Malformed request URI');
			}
		}
		// cannot process request
		else {
			throw new \Exception('Unable to determine the request URI');
		}

		// remove base url
		$base_url = parse_url(Config::get('application.base_url'), PHP_URL_PATH);

		if(strlen($base_url)) {
			if(strpos($uri, $base_url) === 0) {
				$uri = substr($uri, strlen($base_url));
			}
		}

		// remove index file
		$index = '/' . Config::get('application.index_page');

		if(strpos($uri, $index) === 0) {
			$uri = substr($uri, strlen($index));
		}

		// remove trailing slashes
		$uri = trim($uri, '/');

		return $uri;
	}
	
	public static function ajax() {
		if(!isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
			return false;
		}

		return strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
	}
	
	public static function route() {
		return new Router(static::uri());
	}

}

/* End of file */
