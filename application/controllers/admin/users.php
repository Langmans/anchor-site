<?php

class Users_controller extends Auth_controller {

	public function index() {
		$data['title'] = 'Users';
		View::make('admin/users/index', $data);
	}

}