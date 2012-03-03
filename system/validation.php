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

class Validation {

	private static $rules = array();
	private static $failed = array();

	public static function set_rule($field, $rules) {
		static::$rules[$field] = $rules;
	}

	private static function set_error($field, $message) {
		static::$failed[$field][] = $message;
	}

	public static function get_error($field) {
		return isset(static::$failed[$field]) ? static::$failed[$field] : false;
	}

	public static function get_errors() {
		return static::$failed;
	}

	public static function validate_min_length($data, $field, $params) {
		$default = 'Field must contain at least ' . $params['param'] . ' characters';
		$message = isset($params['message']) ? $params['message'] : $default;

		if(strlen($data) < $params['param']) {
			static::set_error($field, $message);
		}
	}

	public static function validate_max_length($data, $field, $params) {
		$default = 'Field cannot contain more than ' . $params['param'] . ' characters';
		$message = isset($params['message']) ? $params['message'] : $default;

		if(strlen($data) > $params['param']) {
			static::set_error($field, $message);
		}
	}

	public static function validate_email($data, $field, $params) {
		$default = 'Invalid email address';
		$message = isset($params['message']) ? $params['message'] : $default;

		// test
		if(filter_var($data, FILTER_VALIDATE_EMAIL) === false) {
			static::set_error($field, $message);
		}
	}

	public static function validate_alnum($data, $field, $params) {
		$default = 'Field must contain alpha-numeric characters only';
		$message = isset($params['message']) ? $params['message'] : $default;

		// test
		if(ctype_alnum($data) === false) {
			static::set_error($field, $message);
		}
	}

	public static function validate_required($data, $field, $params) {
		$default = 'Field is required';
		$message = isset($params['message']) ? $params['message'] : $default;

		// test
		if($data === null) {
			static::set_error($field, $message);
		}
	}

	public static function validate($data = array()) {
		// if no data is given check post data
		if(empty($data) and count($_POST)) {
			$data = $_POST;
		}

		$reflector = new \ReflectionClass(__CLASS__);

		// validate against rules
		foreach(static::$rules as $field => $rules) {
			// loop rules
			foreach($rules as $rule) {
				// set default
				$data[$field] = isset($data[$field]) ? $data[$field] : null;

				// validate rule
				if($reflector->hasMethod('validate_' . $rule['rule'])) {
					// invoke method with rule params
					$reflector->getMethod('validate_' . $rule['rule'])->invoke(null, $data[$field], $field, $rule);
				}
			}
		}

		return count(static::$failed) ? false : true;
	}

}

/* End of file */