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

class Response {

	private static $headers = array();
	private static $content = '';
	public static $status = 200;

	private static $statuses = array(
		100 => 'Continue',
		101 => 'Switching Protocols',
		200 => 'OK',
		201 => 'Created',
		202 => 'Accepted',
		203 => 'Non-Authoritative Information',
		204 => 'No Content',
		205 => 'Reset Content',
		206 => 'Partial Content',
		207 => 'Multi-Status',
		300 => 'Multiple Choices',
		301 => 'Moved Permanently',
		302 => 'Found',
		303 => 'See Other',
		304 => 'Not Modified',
		305 => 'Use Proxy',
		307 => 'Temporary Redirect',
		400 => 'Bad Request',
		401 => 'Unauthorized',
		402 => 'Payment Required',
		403 => 'Forbidden',
		404 => 'Not Found',
		405 => 'Method Not Allowed',
		406 => 'Not Acceptable',
		407 => 'Proxy Authentication Required',
		408 => 'Request Timeout',
		409 => 'Conflict',
		410 => 'Gone',
		411 => 'Length Required',
		412 => 'Precondition Failed',
		413 => 'Request Entity Too Large',
		414 => 'Request-URI Too Long',
		415 => 'Unsupported Media Type',
		416 => 'Requested Range Not Satisfiable',
		417 => 'Expectation Failed',
		422 => 'Unprocessable Entity',
		423 => 'Locked',
		424 => 'Failed Dependency',
		500 => 'Internal Server Error',
		501 => 'Not Implemented',
		502 => 'Bad Gateway',
		503 => 'Service Unavailable',
		504 => 'Gateway Timeout',
		505 => 'HTTP Version Not Supported',
		507 => 'Insufficient Storage',
		509 => 'Bandwidth Limit Exceeded'
	);

	public static function redirect($uri, $status = 302) {
		static::header('Location', Url::make($uri));
		static::content('', $status);
	}
	
	public static function is_redirect() {
		return array_key_exists('Location', static::$headers);
	}

	public static function content($content, $status = 200) {
		static::$status = $status;
		static::$content = $content;
	}

	public static function append($content) {
		static::$content .= $content;
	}

	public static function header($name, $value) {
		static::$headers[$name] = $value;
	}

	public static function send() {
		// set content type
		if(array_key_exists('Content-Type', static::$headers) === false) {
			static::$headers['Content-Type'] = 'text/html; charset=' . Config::get('application.charset');
		}

		// send headers
		if(headers_sent() === false) {
			$protocol = Input::server('server_protocol', 'HTTP/1.1');

			header($protocol . ' ' . static::$status . ' ' . static::$statuses[static::$status]);

			foreach(static::$headers as $name => $value) {
				header($name . ': ' . $value, true);
			}
		}

		// Send it to the browser!
		echo static::$content;
	}

}

/* End of file */
