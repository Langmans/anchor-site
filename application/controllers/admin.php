<?php

class Admin_controller {

	public function index() {
		if(($user = Users::authed()) === false) {
			return Response::redirect('admin/login');
		}

		$data['title'] = 'Dashboard';
		View::make('admin/index', $data);
	}

	public function login() {
		$data['title'] = 'Login';

		if(Input::method() == 'POST') {
			if(Users::login()) {
				return Response::redirect('admin');
			}
		}

		View::make('admin/login', $data);
	}

	public function logout() {
		Users::logout();
		Response::redirect('admin');
	}

}