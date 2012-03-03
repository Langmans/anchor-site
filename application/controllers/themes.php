<?php

class Themes_controller {

	public function index() {
		$data['title'] = 'Themes';
		$data['themes'] = Themes::list_all(array('status' => 'approved'));
		View::make('themes/index', $data);
	}

	public function submit() {
		$data['title'] = 'Theme Submissions';
		View::make('themes/submit', $data);
	}

	public function view($id) {
		$data['title'] = 'Theme Submissions';
		$data['theme'] = Themes::find(array('id' => $id, 'status' => 'approved'));
		View::make('themes/view', $data);
	}

	public function thumbnail($id) {
		Response::header('Content-Type', 'image/png');
		Response::content(file_get_contents('http://placehold.it/350x175'));
	}

	public function preview($id) {
		Response::header('Content-Type', 'image/png');
		Response::content(file_get_contents('http://placehold.it/800x600'));
	}

}