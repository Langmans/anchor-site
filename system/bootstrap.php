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

/**
 * System Front Controller
 */

// base classes
require SYS_PATH . 'autoloader' . EXT;
require SYS_PATH . 'config' . EXT;
require SYS_PATH . 'str' . EXT;

// register auto loader
Autoloader::register();

/**
 * Load configuration files that are loaded for every request to the 
 * application. It is quicker to load them manually each request.
 */
Config::load('aliases');
Config::load('application');
Config::load('session');
Config::load('routes');
Config::load('container');

// Start benchmark
Benchmark::start('total_execution_time');

/**
* Register the default timezone for the application. This will be the
* default timezone used by all date / timezone functions throughout
* the entire application.
*/
date_default_timezone_set(Config::get('application.timezone'));

/**
* Register the PHP exception handler. The framework throws exceptions
* on every error that cannot be handled. All of those exceptions will
* be sent through this closure for processing.
*/
set_exception_handler(function($e) {
	Error::exception($e);
});

/**
* Register the PHP error handler. All PHP errors will fall into this
* handler which will convert the error into an ErrorException object
* and pass the exception into the exception handler.
*/
set_error_handler(function($code, $error, $file, $line) {
	Error::native($code, $error, $file, $line);
});

/**
* Register the shutdown handler. This function will be called at the
* end of the PHP script or on a fatal PHP error. If a PHP error has
* occured, we will convert it to an ErrorException and pass it
* to the common exception handler for the framework.
*/
register_shutdown_function(function() {
	Error::shutdown();
});

/**
 * Load session data
 */
if(Config::get('session.driver')) {
	Session::read(Cookie::get('session'));
}

/*
 * Register DI Container with IoC
 */
IoC::bootstrap();

/**
 * Create Response from requested uri
 */
$router = new Router;

IoC::instance('router', $router);

if(file_exists($router->get_path()) === false) {
	// application controller not found
	Response::content(View::make('errors/error_404'), 404);
} else {
	// Load the application controller
	require $router->get_path();

	$class = $router->get_class();
	
	if(class_exists($class . '_controller')) {
		$class .= '_controller';
	}
	
	if(class_exists($class, false) === false) {
		throw new \ErrorException($class . ' is not defined');
	}

	// create a class reflection to test methods
	$reflector = new \ReflectionClass($class);

	if($reflector->hasMethod($router->get_method()) === false) {
		// method not found in controller
		Response::content(View::make('errors/error_404'), 404);
	} else {
		// construct controller
		$controller = new $class;
		
		// before hook
		if($reflector->hasMethod('before') !== false) {
			$reflector->getMethod('before')->invokeArgs($controller, $router->uri_segments());
		}
	
		// requested method
		if(Response::is_redirect() === false and in_array($router->get_method(), array('before', 'after')) === false) {
			$reflector->getMethod($router->get_method())->invokeArgs($controller, $router->uri_segments());
		}
		
		// after hook
		if($reflector->hasMethod('after') !== false) {
			$reflector->getMethod('after')->invokeArgs($controller, $router->uri_segments());
		}
	}
}

/**
 * Write session data
 */
if(Config::get('session.driver')) {
	Session::write();
}

// Output to browser
Response::send();

/* End of file */
