<?php

class Home_controller {

	public function index() {
		$data['title'] = 'Home';
		View::make('home', $data);
	}

}

