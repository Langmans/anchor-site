<?php

class Themes {
	
	public static function list_all($params = array()) {
		$query = Query::make()->select('*')->from('themes');

		if(isset($params['status'])) {
			$query->where('status', $params['status']);
		}

		if(isset($params['limit'])) {
			$query->limit($params['limit']);

			if(isset($params['offset'])) {
				$query->offset($params['offset']);
			}
		}

		return $query->results();
	}

	public static function find($where = array()) {
		$query = Query::make()->select('*')->from('themes');

		foreach($where as $key => $value) {
			$query->where($key, $value);
		}

		return $query->limit(1)->row();
	}

	public static function parse($theme) {
		$file = PATH . 'submissions/' . $theme . '/about.txt';

		if(file_exists($file) === false) {
			return false;
		}

		// read file into a array
		$contents = explode("\n", trim(file_get_contents($file)));
		$about = array();

		foreach(array('name', 'description', 'author', 'site', 'license') as $index => $key) {
			// temp value
			$about[$key] = '';

			// find line if exists
			if(!isset($contents[$index])) {
				continue;
			}

			$line = $contents[$index];

			// skip if not separated by a colon character
			if(strpos($line, ":") === false) {
				continue;
			}

			$parts = explode(":", $line);
			
			// remove the key part
			array_shift($parts);

			// in case there was a colon in our value part glue it back together
			$value = implode('', $parts);

			$about[$key] = trim($value);
		}

		return $about;
	}

}