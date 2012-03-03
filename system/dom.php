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

class Dom {

	private $document;

	public function __construct($version = '1.0', $encoding = 'utf-8') {
		// create document
		$this->document = new \DOMDocument($version, $encoding);
	}

	public function element($name, $value = null, $attributes = array()) {

		$element = $this->document->createElement($name);

		if(!is_null($value)) {
			$element->nodeValue = $value;
		}

		foreach($attributes as $key => $value) {
			$attr = $this->document->createAttribute($key);
			$element->appendChild($attr);

			if($value) {
				$text = $this->document->createTextNode($value);
				$attr->appendChild($text);
			}
		}

		return $element;
	}

	public function __call($method, $args) {
		if(method_exists($this->document, $method)) {
			return call_user_func_array(array($this->document, $method), $args);
		}
		return false;
	}

	public function save() {
		return $this->document->saveXML();
	}

}

/* End of file */