<?php

/**
 * PeachyPhp
 *
 * Just another PHP Framework
 *
 * @package		peachy-php
 * @author		k. wilson
 * @link		http://peachy-php.co.uk
 */

/**
 * Set the PHP error reporting level. If you set this in php.ini, you remove this.
 * @see  http://php.net/error_reporting
 *
 * When developing your application, it is highly recommended to enable notices
 * and strict warnings. Enable them by using: E_ALL | E_STRICT
 *
 * In a production environment, it is safe to ignore notices and strict warnings.
 * Disable them by using: E_ALL ^ E_NOTICE
 *
 * When using a legacy application with PHP >= 5.3, it is recommended to disable
 * deprecated notices. Disable with: E_ALL & ~E_DEPRECATED
 */
error_reporting(-1);

/**
 * Turning off display_errors will effectively disable error display
 * and logging. You can set error loging in application/config/config.php
 */
ini_set('display_errors', true);

/**
 * Check php environment version, must be 5.3 or greater.
 */
if(version_compare(PHP_VERSION, '5.3.0', '<')) {
	// echo and exit with some usful information
	echo 'Peachy requires PHP 5.3 or newer, current environment is running PHP ' . floatval(PHP_VERSION);
	exit;
}

/**
 * Call anonynous function to keep global workspace clean
 */
call_user_func(function() {
	// directory separator
	if(!defined('DIRECTORY_SEPARATOR')) {
		define('DIRECTORY_SEPARATOR', '/');
	}

	// The directory in which the resources are located.
	$system = "../system";

	// The directory in which your application specific resources are located.
	$application = "../application";

	// Define application and system paths
	$pathinfo = pathinfo(__FILE__);

	// define globals
	define('BASE_PATH', dirname($pathinfo['dirname']) . DIRECTORY_SEPARATOR);
	define('SELF', $pathinfo['basename']);

	/**
	 * The default extension of resource files. If you change this, all resources
	 * must be renamed to use the new extension.
	 */
	define('EXT', '.' . $pathinfo['extension']);

	if(!is_dir($system) and is_dir(BASE_PATH . $system)) {
		$system = BASE_PATH . $system;
	}

	if(!is_dir($application) and is_dir(BASE_PATH . $application)) {
		$application = BASE_PATH . $application;
	}

	// Define the absolute paths for configured directories
	define('SYS_PATH', str_replace("\\", "/", realpath($system)).'/');
	define('APP_PATH', str_replace("\\", "/", realpath($application)).'/');
});

// Load boot strap
require SYS_PATH . 'bootstrap' . EXT;

/* End of file */
