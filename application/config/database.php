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
 * Database connections
 * --------------------
 *
 *  ['driver'] The database type. - Check here for more details http://php.net/manual/en/pdo.drivers.php
 *	['hostname'] The hostname of your database server.
 *	['username'] The username used to connect to the database
 *	['password'] The password used to connect to the database
 *	['database'] The name of the database you want to connect to
 *  ['driver_options'] PDO Drivers options
 *	['debug'] Display sql errors
 */

return array(
	'default' => 'mysql',
	
	'connections' => array(
		'mysql' => array(
			'driver' => 'mysql',
			'hostname' => 'localhost',
			'username' => 'root',
			'password' => 'bottle',
			'database' => 'anchorsite',
			'driver_options' => array(),
			'debug' => false
		)
	)
);