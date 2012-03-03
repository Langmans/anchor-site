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

class Cart {

	private $items = array();
	
	public function __construct($items = array()) {
		$this->items = $items;
	}

	public function add($id, $props = array()) {
		$this->items[$id] = $props;
	}
	
	public function remove($id) {
		unset($this->items[$id]);
	}
	
	public function total() {
		return count($this->items);
	}

	public function sum($field = 'amount') {
		$sum = 0;
		
		foreach($this->items as $item) {
			if(isset($item[$field])) {
				$sum += $item[$field];
			}
		}

		return $sum;
	}

	public function view() {
		return $this->items;
	}

}

/* End of file */
