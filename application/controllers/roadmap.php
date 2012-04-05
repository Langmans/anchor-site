<?php

class Roadmap_controller {

	public function index() {
		$data['title'] = 'Roadmap';
		View::make('roadmap', $data);
	}

}

