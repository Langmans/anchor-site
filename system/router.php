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

class Router {

	private $uri_string = '';
	private $uri_segments = array();
	private $routes = array();
	private $default_controller;
	private $default_method = 'index';
	private $directory = '';

	public function __construct($uri = '') {
		// get defaults from config
		$this->default_controller = Config::get('routes.default.controller');
		$this->default_method = Config::get('routes.default.method');

		// set uri string
		$this->uri_string = strlen($uri) ? $uri : Request::uri();

		// set routes
		$this->parse_routes();

		// set segments
		$this->set_uri_segments();
	}

	private function parse_routes() {
		// set routes from config
		$this->routes = Config::get('routes', array());

		// remove default
		unset($this->routes['default']);

		// is there any custom routes
		if(empty($this->routes)) {
			// nothing to parse
			return;
		}

		// define wild-cards
		$search = array(':any', ':num');
		$replace = array('[0-9a-zA-Z~%\.:_\\-]+', '[0-9]+');

		// uri string
		$uri_str = $this->uri_string();

		// parse routes
		foreach($this->routes as $route => $uri) {
			// replace wildcards
			$route = str_replace($search, $replace, $route);

			// look for matches
			if(preg_match('#' . $route . '#', $uri_str, $matches)) {

				// replace matched values
				foreach($matches as $k => $match) {
					$uri = str_replace('$' . $k, $match, $uri);
				}

				// set new uri string
				$this->uri_string =  $uri;

				// return on first match
				return;
			}
		}
	}

	private function set_uri_segments() {
		// create segments from uri
		$segments = explode(DIRECTORY_SEPARATOR, $this->uri_string());
		$this->uri_segments = $segments;
		
		// no segments nothing else to do
		if(empty($segments)) {
			return;
		}
		
		// path to controllers
		$path = APP_PATH . 'controllers' . DIRECTORY_SEPARATOR;
		
		// set directory
		while(isset($this->uri_segments[0]) and is_dir($path . $this->directory . $this->uri_segments[0])) {
			// Set the directory and remove it from the segment array
			$this->set_directory(array_shift($this->uri_segments));
		}

		// check a controller can be found in sub-folder
		if($this->directory) {
			if(
				(
					// Does the the default controller exist in the sub-folder
					file_exists($path . $this->directory . $this->default_controller . EXT) === false
				) and (
					// Does the requested controller exist in the sub-folder
					(
						empty($this->uri_segments)
					) or (
						isset($this->uri_segments[0]) and
						file_exists($path . $this->directory . $this->uri_segments[0] . EXT) === false
					)
				)
			) {
				// reset
				$this->directory = '';
				$this->uri_segments = $segments;
			}
		}
	}

	private function set_directory($dir) {
		$this->directory .= $dir . DIRECTORY_SEPARATOR;
	}

	public function uri_segments() {
		// remove controller and method
		return array_slice($this->uri_segments, 2);
	}

	public function uri_string() {
		return $this->uri_string;
	}

	public function get_directory() {
		return $this->directory;
	}

	public function get_class() {
		if(isset($this->uri_segments[0]) and $this->uri_segments[0] != "") {
			return $this->uri_segments[0];
		}

		return $this->default_controller;
	}

	public function get_method() {
		if(isset($this->uri_segments[1]) and $this->uri_segments[1] != "") {
			return $this->uri_segments[1];
		}

		return $this->default_method;
	}

	public function get_path() {
		return APP_PATH . 'controllers' . DIRECTORY_SEPARATOR . $this->get_directory() . $this->get_class() . EXT;
	}

}