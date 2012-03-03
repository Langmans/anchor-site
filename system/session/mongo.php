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

class Mongo implements Driver {

	private $db, $conn;
	
	public function __construct() {
		$this->conn = new \Mongo;
		$this->db = $this->conn->selectDB(Config::get('session.table'));
	}

	public function read($id) {
		$collection = $this->db->selectCollection(Config::get('session.table'));
		$cursor = $collection->find(array('id' => $id))->limit(1);

		if($cursor->count()) {
			$doc = $cursor->getNext();

			// decrypt data
			$data = unserialize(Crypt::decrypt($doc['data']));
			
			return array('id' => $doc['id'], 'last_activity' => $doc['last_activity'], 'data' => $data);
		}
		
		return false;
	}

	public function write($session) {
		$collection = $this->db->selectCollection(Config::get('session.table'));
		
		// out with the old
		$collection->remove(array('id' => $session['id']));
		
		// encrypt data
		$session['data'] = Crypt::encrypt(serialize($session['data']));
		
		// in with the new
		return $collection->insert($session);
	}

}

/* End of file */