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

class Alternator {
        
	/**
	 * The values that are to be alternated.
	 * @var array
	 */
	private $values = array();

	/**
	 * Count of the array, used to increase performance.
	 * @var int
	 */
	private $count = 0;

	/**
	 * The current index. Starts as -1 so the first index will be 0.
	 * @var int
	 */
	private $cur = -1;

	/**
	 * Creates new instances of the Alternator.
	 * @param type $values Create
	 */
	public function __construct($values) {
		$this->values = $values;
		$this->count = count($values);
	}

	/**
	 * Gets the next value in the rotation.
	 */
	public function go() {
		return $this->values[$this->cur = ++$this->cur % $this->count];
	}

	/**
	 * Resets the Alternator
	 */
	public function reset() {
		$this->cur = 0;
	}
        
}

/* End of file */