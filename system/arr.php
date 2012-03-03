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

class Arr implements \Iterator {

    private $index = 0;
	private $items = array();
	
	public function __construct($data = array()) {
		if(is_array($data) and count($data)) {
			$this->items = array_values($data);
		}
	}

	/*
		Iterator methods
	*/
    public function rewind() {
        $this->index = 0;
    }

    public function current() {
        return $this->items[$this->index];
    }

    public function key() {
        return $this->index;
    }

    public function next() {
        ++$this->index;
    }

    public function valid() {
        return isset($this->items[$this->index]);
    }
    
    /*
    	Adding items
    */
	public function append($item) {
		if(is_string($item)) {
			$this->items[] = $item;
		} elseif(is_array($item)) {
			$this->merge($item);
		} elseif(is_object($item)) {
			$this->merge(get_object_vars($item));
		}
	}
	
	public function merge($arr) {
		$this->items = array_merge($this->items, array_values($arr));
	}
	
	/*
		Getting items
	*/
	public function length() {
		return count($this->items);
	}
	
	public function pop() {
		return $this->items[count($this->items) - 1];
	}
	
	public function shift() {
		return $this->items[0];
	}
	
	public function search($str, $default = false) {
		foreach($this->items as $index => $value) {
			if($str == $value) {
				return $index;
			}
		}
		
		return $default;
	}
	
	public function slice($offset) {
		$arguments = func_get_args();
		$length = isset($arguments[1]) ? $arguments[1] : count($this->items);
		return array_slice($this->items, $offset, $length);
	}
	
	public function get($index = null, $default = false) {
		if(is_null($index)) {
			return $this->items;
		}

		return isset($this->items[$index]) ? $this->items[$index] : $default;
	}
	
	/*
		Magic methods
	*/
	public function __toString() {
		return implode(',', $this->items);
	}

	/*
		Removing Items
	*/
	public function remove($index) {
		if(!isset($this->items[$index])) {
			return false;
		}
		
		unset($this->items[$index]);

		$this->items = array_values($this->items);
		$this->rewind();
		
		return true;
	}

	/*
		Modifiers
	*/
	public function sort($callable = false) {
		$sorting = array();
		$sorted = array();
		
		if(is_callable($callable)) {
			foreach($this->items as $index => $value) {
				$sorting[$index] = call_user_func($callable, $value, $index);
			}

			asort($sorting);
			
			foreach(array_keys($sorting) as $index) {
				$sorted[] = $this->items[$index];
			}
			
			$this->items = $sorted;
		} else {
			sort($this->items);
		}
		
		$this->rewind();
		
		return $this;
	}
	
	public function reverse() {
		$this->items = array_reverse($this->items);
		$this->rewind();
		
		return $this;
	}
	
	public function shuffle() {
		shuffle($this->items);
		$this->rewind();
		
		return $this;
	}
	
	public function apply($callable) {
		if(is_callable($callable)) {
			foreach($this->items as $index => $value) {
				$this->items[$index] = call_user_func($callable, $value, $index);
			}
		}
		
		return $this;
	}

}

/* End of file */
