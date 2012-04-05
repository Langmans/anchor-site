<?php

class Users {
	
	public static function authed() {
		return Session::get('user');
	}

	public static function find($where = array()) {
		$query = Query::make()->select('*')->from('users');

		foreach($where as $key => $value) {
			$query->where($key, $value);
		}

		return $query->row();
	}

	public static function login() {
		$post = Input::post(array('email', 'password'));
		$errors = array();

		if(empty($post['email'])) {
			$errors[] = 'Please enter your email address';
		}

		if(empty($post['password'])) {
			$errors[] = 'Please enter your password';
		}

		if(count($errors)) {
			Notifications::add('error', $errors);
			return false;
		}

		if($user = Users::find(array('email' => $post['email']))) {
			if(crypt($post['password'], $user->password) != $user->password) {
				$errors[] = 'Invalid details';
			}
		} else {
			$errors[] = 'Invalid details';
		}

		if(count($errors)) {
			Notifications::add('error', $errors);
			return false;
		}

		Session::set('user', $user);

		return true;
	}

	public static function logout() {
		Session::forget('user');
	}

}