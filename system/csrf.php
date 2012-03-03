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

class Csrf {

	private $token = '';
	private $algorithm = 'md5';
	private $token_name = 'csrf_token';

	public function __construct($params = array()) {
		// read token
		$this->read();
	}
	
	private function make() {
		$this->token = hash($this->algorithm, Str::random(40));
	}

	private function read() {
		// read token from session
		if(($token = Session::get($this->token_name)) !== false) {
			// set token
			$this->token = $token;
		} else {
			// generate token
			$this->make();

			// save session token
			Session::set($this->token_name, $this->token);
		}
	}

	public function generate() {
		// generate token
		$this->make();

		// save session token
		Session::set($this->token_name, $this->token);
	}

	public function valid($token) {
		// test session token
		return $token === $this->token;
	}

	public function form_token($name) {
		return '<input name="' . $name . '" type="hidden" value="' . $this->token . '" />';
	}

	public function token() {
		return $this->token;
	}

}

/* End of file */