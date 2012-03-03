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

/*
 * Specification
 * http://cyber.law.harvard.edu/rss/rss.html
 */
class Rss {

	private $doc = null;
	private $channel = null;

	public function __construct($params = array()) {
		// create document
		$this->doc = new Dom;
		$this->doc->formatOutput = true;

		// rss and version
		$rss = $this->doc->element('rss', null, array(
			'version' => '2.0',
			'xmlns:atom' => 'http://www.w3.org/2005/Atom'
		));
		$this->doc->appendChild($rss);

    	/*
		 * Channel
		 */
		$defaults = array(
			'title' => 'Untitled',
			'description' => '',
			'link' => '',
			'self' => '',
			'language' => 'en-gb',
			'ttl' => 40
		);

		foreach($defaults as $key => $default) {
			$params[$key] = isset($params[$key]) ? $params[$key] : $default;
		}

    	$this->channel = $this->doc->element('channel');
    	$rss->appendChild($this->channel);
    	
		// Missing atom:link with rel="self"
		// http://validator.w3.org/feed/docs/warning/MissingAtomSelfLink.html
		$atom = $this->doc->element('atom:link', null, array(
			'href' => $params['self'],
			'rel' => 'self',
			'type' => 'application/rss+xml'
		));
		$this->channel->appendChild($atom);

		// title
		$title = $this->doc->element('title', $params['title']);
		$this->channel->appendChild($title);

		// link
		$link = $this->doc->element('link', $params['link']);
		$this->channel->appendChild($link);

		// description
		$description = $this->doc->element('description', $params['description']);
		$this->channel->appendChild($description);

		// language
		$language = $this->doc->element('language', $params['language']);
		$this->channel->appendChild($language);

		// ttl
		$ttl = $this->doc->element('ttl', $params['ttl']);
		$this->channel->appendChild($ttl);
	}

	public function add_item($itm) {
		// channel
		$item = $this->doc->element('item');
		$this->channel->appendChild($item);

		// title
		$title = $this->doc->element('title', $itm['title']);
		$item->appendChild($title);

		// description
		$description = $this->doc->element('description', $itm['description']);
		$item->appendChild($description);

		// date
		$pubDate = $this->doc->element('pubDate', $itm['date']);
		$item->appendChild($pubDate);

		// link
		$link = $this->doc->element('link', $itm['link']);
		$item->appendChild($link);

		$guid = $this->doc->element('guid', $itm['link']);
		$item->appendChild($guid);
	}

	public function display() {
		Response::header('Content-Type', 'text/xml');
		Response::content($this->doc->save());
	}

}

/* End of file */