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

class Db {

	private static $driver = 'mysql';
	private static $hostname;
	private static $username;
	private static $password;
	private static $database;
	private static $driver_options = array();
	private static $debug = false;

	private static $dbh = null;
	private static $affected_rows = 0;

	private static $query_count = 0;
	private static $queries = array();
	private static $profile = array();
	
	// keyword identifier
	private static $wrapper = '`';

	public static function connect($params = '') {

		if(empty($params)) {
			Config::load('database');
			$params = Config::get('database.connections.' . Config::get('database.default'));
		} elseif(is_string($params)) {
			/*
			 * Parse the URL from the DSN string
			 *
			 * Database settings can be passed as discreet
			 * parameters or as a data source name in the first
			 * parameter. DSNs must have this prototype:
			 *
			 * $dsn = 'driver://username:password@hostname/database';
			 */
			if(($dns = @parse_url($params)) === false) {
				throw new \Exception('Invalid DB Connection String');
			}

			$params = array(
				'driver' => $dns['scheme'],
				'hostname' => isset($dns['host']) ? rawurldecode($dns['host']) : '',
				'username' => isset($dns['user']) ? rawurldecode($dns['user']) : '',
				'password' => isset($dns['pass']) ? rawurldecode($dns['pass']) : '',
				'database' => isset($dns['path']) ? rawurldecode(substr($dns['path'], 1)) : ''
			);
		}

		if(is_array($params)) {
			foreach($params as $key => $value) {
				static::$$key = $value;
			}
		}

		unset($params);

		// build dns string
		$dsn = static::$driver . ':dbname=' . static::$database . ';host=' . static::$hostname;

		// try connection
		static::$dbh = new \PDO($dsn, static::$username, static::$password, static::$driver_options);
		
		// set error handling to exceptions
		static::$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);

		return true;
	}

	public static function close() {
		static::$dbh = null;
	}

	/*
	 * Querying
	 */
	public static function query($sql, $binds = array()) {
		// make sure we have a connection
		if(is_null(static::$dbh)) {
			static::connect();
		}
	
		// check binds
		if(!is_array($binds)) {
			$binds = array($binds);
		}

		// benchmarking
		if(static::$debug) {
			Benchmark::start('sql');
		}

		// prepare
		$sth = static::$dbh->prepare($sql);

		// get results
		$sth->execute($binds);

		// profiling
		if(static::$debug) {
			static::$profile[] = array(
				'sql' => $sql,
				'params' => $binds,
				'time' => Benchmark::check('sql', 6),
				'rows' => $sth->rowCount()
			);
		}

		// Save the query for debugging
		static::$queries[] = $sth->queryString;

		// query count
		static::$query_count++;

		// update affected rows
		static::$affected_rows = $sth->rowCount();

		// return statement
		return $sth;
	}

	/*
	 * Simple query, returns TRUE or FALSE
	 */
	public static function exec($sql, $binds = false) {
		// make sure we have a connection
		if(is_null(static::$dbh)) {
			static::connect();
		}

		// check binds
		if(!is_array($binds)) {
			$binds = array($binds);
		}

		// benchmarking
		if(static::$debug) {
			Benchmark::start('sql');
		}

		// prepare
		$sth = static::$dbh->prepare($sql);

		// get results
		$result = $sth->execute($binds);

		// profiling
		if(static::$debug) {
			static::$profile[] = array(
				'sql' => $sql,
				'params' => $binds,
				'time' => Benchmark::check('sql', 6),
				'rows' => $sth->rowCount()
			);
		}

		// Save the query for debugging
		static::$queries[] = $sth->queryString;

		// query count
		static::$query_count++;

		// update affected rows
		static::$affected_rows = $sth->rowCount();

		// return result
		return $result;
	}
	
	/*
	 * Shortcuts
	 */
	public static function row($sql, $binds = array(), $fetch_style = \PDO::FETCH_OBJ) {
		// get statement
		$stm = static::query($sql, $binds);

		// return data
		return $stm->fetch($fetch_style);
	}

	public static function results($sql, $binds = array(), $fetch_style = \PDO::FETCH_OBJ) {
		// get statement
		$stm = static::query($sql, $binds);

		// return data array
		return $stm->fetchAll($fetch_style);
	}

	/*
	 * Aliases
	 */
	public static function insert_id() {
		return static::$dbh->lastInsertId();
	}

	public static function affected_rows() {
		return static::$affected_rows;
	}

	public static function total_queries() {
		return static::$query_count;
	}

	public static function last_query() {
		return end(static::$queries);
	}

	public static function profile() {
		if(!static::$debug) {
			return false;
		}

		return static::$profile;
	}
	
	/*
	 * call methods on PDO statically
	 */
	public static function __callStatic($name, $arguments) {	
		// make sure we have a connection
		if(is_null(static::$dbh)) {
			static::connect();
		}

		$reflector = new \ReflectionClass('PDO');
		
		if($reflector->hasMethod($name)) {
			return $reflector->getMethod($name)->invokeArgs(static::$dbh, $arguments);
		}

		return false;
	}

}

/* End of file */
