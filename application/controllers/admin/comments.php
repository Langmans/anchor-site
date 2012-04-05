<?php

class Comments_controller extends Auth_controller {

	public function index() {
		$data['title'] = 'Comments';
		View::make('admin/comments/index', $data);
	}

}