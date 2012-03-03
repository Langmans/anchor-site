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

class Filesystem {

	public static function read($file) {
		if(file_exists($file)) {
			return file_get_contents($file);
		}

		return false;
	}

	public static function write($path, $data, $mode = 'w+') {
		if(!$fp = @fopen($path, $mode)) {
			return false;
		}

		flock($fp, LOCK_EX);
		fwrite($fp, $data);
		flock($fp, LOCK_UN);
		fclose($fp);

		return true;
	}
	
	public static function unlink($file) {
		if(file_exists($file)) {
			unlink($file);
		}
		
		return true;
	}

	public static function rmdir($path) {
		// Trim the trailing slash
		$path = rtrim($path, DIRECTORY_SEPARATOR);

		if(!$current_dir = @opendir($path)) {
			return false;
		}

		while(false !== ($filename = @readdir($current_dir))) {
			if($filename != "." and $filename != "..") {
				$filepath = $path . DIRECTORY_SEPARATOR . $filename;
				
				if(is_dir($filepath)) {
					static::rmdir($filepath);
				} else {
					static::unlink($filepath);
				}
			}
		}

		closedir($current_dir);

		rmdir($path);
	}

	public static function extension($file) {
		return strtolower(pathinfo($file, PATHINFO_EXTENSION));
	}

}

/* End of file */
