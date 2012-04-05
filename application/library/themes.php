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

	public static function viewing($id) {
		$total = Query::make()->select('views')->from('themes')->where('id', $id)->limit(1)->col();
		return Query::make()->update('themes', array('views' => ($total + 1)))->where('id', $id)->go();
	}

	public static function downloading($id) {
		$total = Query::make()->select('downloads ')->from('themes')->where('id', $id)->limit(1)->col();
		return Query::make()->update('themes', array('downloads ' => ($total + 1)))->where('id', $id)->go();
	}

	private static function upload_error($code) {
		switch($code) {
			case UPLOAD_ERR_INI_SIZE:
			case UPLOAD_ERR_FORM_SIZE:
				return 'File size is to big.';
			case UPLOAD_ERR_NO_FILE:
			case UPLOAD_ERR_EXTENSION:
				return 'Please select a file to upload.';
			case UPLOAD_ERR_CANT_WRITE:
				return 'There was a problem uploading your file, the upload folder is missing or unwritable.';
			case UPLOAD_ERR_PARTIAL:
			case UPLOAD_ERR_NO_TMP_DIR:
			default:
				return 'There was a problem uploading your file, please try again.';
		}
	}

	public static function upload() {
		$file = Input::file('theme');
		$tos= Input::post('tos');
		$errors = array();

		// tos
		if(empty($tos)) {
			$errors[] = 'You must accpet the terms and conditions to submit your theme.';
		}

		// check upload
		if($file['error'] !== UPLOAD_ERR_OK) {
			$errors[] = static::upload_error($file['error']);
		} elseif($file['size'] == 0) {
			$errors[] = 'Please select a file to upload.';
		}

		if(count($errors)) {
			Notifications::add('error', $errors);
			return false;
		}

		// check mime type

		$mimes = array('application/zip', 'application/x-zip', 'application/x-zip-compressed');

		if(in_array($file['type'], $mimes) === false) {
			$errors[] = 'Only zip files are accepted.';
		}

		if(count($errors)) {
			Notifications::add('error', $errors);
			return false;
		}

		// check zip archive

		$file['name'] = hash('crc32', file_get_contents($file['tmp_name']));
		$file['path'] = BASE_PATH . 'themes/'. $file['name'] . '.zip';

		if(move_uploaded_file($file['tmp_name'], $file['path']) === false) {
			$errors[] = 'Failed to move file to destination path.';
		}

		// extract zip file
		$zip = new ZipArchive;

		if($zip->open($file['path']) === false) {
			$errors[] = 'Could not open zip archive.';
		}

		if(count($errors)) {
			// clean up
			Filesystem::unlink($file['path']);

			Notifications::add('error', $errors);
			return false;
		}

		// extract content
		$dir = BASE_PATH . 'themes/'. $file['name'] . '/';

		mkdir($dir);

		$zip->extractTo($dir);

		// validate about.txt file
		$data = static::parse($file['name']);

		if($data === false) {
			$error[] = 'It looks like your about.txt file is missing.';
		} elseif(empty($data['name']) or empty($data['description']) or empty($data['author'])) {
			$error[] = 'Please check your about.txt theme file, make sure you include the name, description and author details.';
		}

		if(count($errors)) {
			// clean up
			Filesystem::unlink($file['path']);

			// remove extracted data
			Filesystem::rmdir($dir);

			Notifications::add('error', $errors);
			return false;
		}

		// create thumbnails
		if(is_readable($dir . 'preview.png')) {
			Image::open($dir . 'preview.png')->resize('350', '175')->output('png', BASE_PATH . 'thumbnails/' . $file['name'] . '.png');
			Image::open($dir . 'preview.png')->resize('800', '600')->output('png', BASE_PATH . 'previews/' . $file['name'] . '.png');
		}

		// looks good clean up and add to database
		Filesystem::rmdir($dir);

		Query::make()->insert('themes', array(
			'uploaded' => date("c"),
			'checksum' => $file['name'],

			'author' => $data['author'],
			'site' => $data['site'],
			'name' => $data['name'],
			'description' => $data['description'],

			'status' => 'pending',
			'views' => 0,
			'downloads' => 0
		))->go();

		Notifications::add('success', 'Congratulations! your theme has been added and is now pending for review.');

		return true;
	}

	public static function parse($theme) {
		$file = BASE_PATH . 'themes/' . $theme . '/about.txt';

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

	public static function update($id) {
		$post = Input::post(array('author', 'site', 'name', 'description', 'status'));
		$errors = array();

		if(Input::post('delete') !== false) {
			return static::delete($id);
		}

		if(empty($post['author'])) {
			$errors[] = 'Please enter a author';
		}

		if(empty($post['name'])) {
			$errors[] = 'Please enter a name';
		}

		if(empty($post['description'])) {
			$errors[] = 'Please enter a description';
		}

		if(count($errors)) {
			Notifications::add('error', $errors);
			return false;
		}

		Query::make()->update('themes', $post)->where('id', $id)->go();

		Notifications::add('success', 'Theme updated');

		return true;
	}

	public static function delete($id) {
		// clean up files
		$theme = static::find(array('id' => $id));

		foreach(array(
			BASE_PATH . 'previews/' . $theme->checksum . '.png',
			BASE_PATH . 'thumbnails/' . $theme->checksum . '.png',
			BASE_PATH . 'themes/' . $theme->checksum . '.zip'
		) as $file) {
			if(file_exists($file)) {
				unlink($file);
			}
		}

		// remove from database
		Query::make()->delete('themes')->where('id', $id)->go();

		Notifications::add('notice', 'Theme removed');

		return true;
	}

}