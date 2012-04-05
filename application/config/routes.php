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

/*
 * URI Routing
 * -----------------------
 * There is a one-to-one relationship between a URL string
 * and its corresponding controller class/method. The segments in a
 * URI normally follow this pattern:
 *
 * example.com/class/method/id/
 *
 * Default Routes
 * -----------------------
 * This route indicates which controller class should be loaded if the
 * URI contains no data. In the above example, the "default" class
 * would be loaded.
 *
 * Routes
 * -----------------------
 * Note: The order in which you define your routes is very important,
 * when parsing the routes it will stop at the first match.
 */

return array(
	'default' => array(
		'controller' => 'home',
		'method' => 'index'
	),
	'^docs/(.+)' => 'docs/view/$1'
);

