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

class Cookie implements Driver {

	public function read($id) {
		if(\System\Cookie::has('payload')) {
			return @unserialize(Crypt::decrypt(\System\Cookie::get('payload')));
		}
	}

	public function write($session) {
		$session['last_activity'] = date("c");
		$data = Crypt::encrypt(serialize($session));
		\System\Cookie::write('payload', $data, time() + Config::get('session.expire'), Config::get('session.path'), Config::get('session.domain'));
	}

}

/* End of file */
