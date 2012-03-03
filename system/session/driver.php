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
 
interface Driver {

	public function read($id);

	public function write($session);

}

/* End of file */