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

class Ftp {

	private $conn;
	private $messages = array();

	public function get_messages() {
		return $this->messages;
	}

	public function get_message() {
		return end($this->messages);
	}

	public function connect($server, $username, $password, $passive = false) {
		if(($this->conn = ftp_connect($server)) === false) {
			$this->messages[] = 'Server not found';
			return false;
		}

		if(@ftp_login($this->conn, $username, $password) === false) {
			$this->disconnect();
			$this->messages[] = 'Invalid login details';
			return false;
		}

		if($passive) {
			ftp_pasv($this->conn, true);
		}

		return true;
	}

	public function disconnect() {
		return ftp_close($this->conn);
	}

	public function get($local_file, $server_file, $mode = '', $startpos = 0) {
		// transfer mode
		$mode = ($mode == 'ascii') ? FTP_ASCII : FTP_BINARY;

		if(!ftp_get($this->conn, $server_file, $local_file, $mode, $startpos)) {
			$this->messages[] = 'Failed to download file: ' . $server_file;
			return false;
		}

		return true;
	}

	public function put($local_file, $server_file, $mode = '', $startpos = 0) {
		// allocated space for file
		if(!ftp_alloc($this->conn, filesize($local_file), $response)) {
			$this->messages[] = $response;
			return false;
		}

		// transfer mode
		$mode = ($mode == 'ascii') ? FTP_ASCII : FTP_BINARY;

		if(!ftp_put($this->conn, $server_file, $local_file, $mode, $startpos)) {
			$this->messages[] = 'Failed to upload file: ' . $local_file;
			return false;
		}

		return true;
	}

	public function delete($server_file) {
		if(!ftp_delete($this->conn, $server_file)) {
			$this->messages[] = 'Failed to delete file: ' . $server_file;
			return false;
		}

		return true;
	}

	public function size($server_file) {
		if(($size = ftp_size($this->conn, $server_file)) === -1) {
			$this->messages[] = 'Failed to get size on file: ' . $server_file;
			return false;
		}

		return $size;
	}

	public function rename($old_file, $new_file) {
		if(!ftp_rename($this->conn, $old_file, $new_file)) {
			$this->messages[] = 'Failed to rename file: ' . $old_file;
			return false;
		}

		return true;
	}

	public function move($old_file, $new_file) {
		if(!ftp_rename($this->conn, $old_file, $new_file)) {
			$this->messages[] = 'Failed to move file: ' . $old_file;
			return false;
		}

		return true;
	}

	public function chmod($server_file, $permissions) {
		if(ftp_chmod($this->conn, $permissions, $server_file) === false) {
			$this->messages[] = 'Failed to chmod file: ' . $server_file;
			return false;
		}

		return true;
	}

	public function mkdir($directory, $permissions = '') {
		if(!ftp_mkdir($this->conn, $directory)) {
			$this->messages[] = 'Failed to create directory: ' . $directory;
			return false;
		}

		if($permissions) {
			$this->chmod($directory, $permissions);
		}

		return true;
	}

	public function rmdir($directory) {
		// get folder contents
		if(($contents = $this->ls($directory)) === false) {
			return false;
		}

		// remove files and folders
		if(count($contents)) {
			foreach($contents as $file) {
				// file or directory
				if($this->size($file)) {
					$this->delete($file);
				} else {
					$this->rmdir($file);
				}
			}
		}

		if(!ftp_rmdir($this->conn, $directory)) {
			$this->messages[] = 'Failed to remove directory: ' . $directory;
			return false;
		}

		return true;
	}

	public function ls($directory = '.') {
		if(($contents = ftp_nlist($this->conn, $directory)) === false) {
			$this->messages[] = 'Failed to list directory: ' . $directory;
			return false;
		}

		return $contents;
	}

	public function chdir($directory) {
		if(!ftp_chdir($this->conn, $directory)) {
			$this->messages[] = 'Failed to change directory: ' . $directory;
			return false;
		}

		return true;
	}

	public function pwd() {
		if(($directory = ftp_pwd($this->conn)) === false) {
			$this->messages[] = 'Failed to get working directory';
			return false;
		}

		return $directory;
	}

	public function cmd($command) {
		return ftp_raw($this->conn, trim($command));
	}

}

/* End of file */