<?php

class Download_controller {

	public function index() {
		$data['title'] = 'Download';
		View::make('download', $data);
	}

}