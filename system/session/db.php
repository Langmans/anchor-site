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
use System\Db\Query;

class Db implements Driver {

	public function read($id) {
		$session = Query::make()
			->select('*')
			->from(Config::get('session.table'))
			->where('id', $id)
			->limit(1)
			->row(\PDO::FETCH_ASSOC);

		if($session) {
			$session['data'] = unserialize($session['data']); //unserialize(Crypt::decrypt($session['data']));
			return $session;
		}
		
		return false;
	}

	public function write($session) {
		// out with the old
		Query::make()
			->delete(Config::get('session.table'))
			->where('id', $session['id'])
			->go();
		
		// encrypt data
		$session['data'] = serialize($session['data']); //Crypt::encrypt(serialize($session['data']));
		
		// in with the new
		return Query::make()
			->insert(Config::get('session.table'), $session)
			->go();
	}

}

/* End of file */