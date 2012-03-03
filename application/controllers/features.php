<?php

class Features_controller {

	public function index() {
		$data['title'] = 'Features';
		View::make('features', $data);
	}

}