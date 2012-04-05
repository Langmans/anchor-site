<?php

class Auth_controller {
	
	public function before() {
		if(Users::authed() === false) {
			Response::redirect('admin/login');
		}
	}

}