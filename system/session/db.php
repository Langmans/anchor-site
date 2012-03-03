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

class Db implements Driver {

	public function read($id) {
		$query = \System\Db\Query::make()
			->select('*')
			->from(Config::get('session.table'))
			->where('id', $id)
			->limit(1);

		if($session = \System\Db::row($query->sql(), $query->bindings(), \PDO::FETCH_ASSOC)) {
			$session['data'] = unserialize(Crypt::decrypt($session['data']));
			return $session;
		}
		
		return false;
	}

	public function write($session) {
		// out with the old
		\System\Db\Query::make()
			->delete(Config::get('session.table'))
			->where('id', $session['id'])
			->go();
		
		// encrypt data
		$session['data'] = Crypt::encrypt(serialize($session['data']));
		
		// in with the new
		return \System\Db\Query::make()
			->insert(Config::get('session.table'), $session)
			->go();
	}

}

/* End of file */