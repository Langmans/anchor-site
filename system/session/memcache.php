<?php namespace System\Session;

/**
 * PeachyPhp
 *
 * Just another PHP Framework
 *
 * @package		peachy-php
 * @author		k. wilson
 * @link		http://peachy-php.co.uk
 */

use System\Config;
use System\Crypt;

class Memcache implements Driver {

	private $db;
	
	public function __construct() {
		$this->db = new \Memcache;

		if($this->db->connect('localhost', 11211) === false) {
			throw new \ErrorException('Failed to connect to memcache localhost');
		}
	}

	public function read($id) {
		if($session = $this->db->get($id)) {
			if($data = @unserialize(Crypt::decrypt($session['data']))) {
				$session['data'] = $data;
				return $session;
			}
		}
		return false;
	}

	public function write($session) {
		$session['data'] = Crypt::encrypt(serialize($session['data']));
		return $this->db->set($session['id'], $session, false, Config::get('session.expire'));
	}

}

/* End of file */