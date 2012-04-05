<?php

class Themes_controller {

	public function index() {
		$data['title'] = 'Themes';
		$data['themes'] = Themes::list_all(array('status' => 'approved'));
		View::make('themes/index', $data);
	}

	public function submit() {
		$data['title'] = 'Submit your theme';

		if(Input::method() == 'POST') {
			Themes::upload();
			return Response::redirect('themes/submit');
		}

		View::make('themes/submit', $data);
	}

	public function view($id) {
		
		Themes::viewing($id);
		$data['theme'] = ($theme = Themes::find(array('id' => $id, 'status' => 'approved')));
		$data['title'] = 'Themes &middot; ' . $theme->name . ' by ' . $theme->author;

		View::make('themes/view', $data);
	}

	public function help() {
		$data['title'] = 'Themes Help';
		View::make('themes/help', $data);
	}

	public function download($id) {
		Themes::downloading($id);
		$theme = Themes::find(array('id' => $id, 'status' => 'approved'));
		$path = BASE_PATH . 'themes/' . $theme->checksum . '.zip';

		Response::header('Content-Type', 'application/zip');
		Response::header('Content-Disposition', 'attachment; filename="' . Url::title($theme->name . ' by ' . $theme->author) . '.zip"');
		Response::content(file_get_contents($path));
	}

	public function thumbnail($id) {
		$theme = Themes::find(array('id' => $id, 'status' => 'approved'));
		$path = BASE_PATH . 'thumbnails/' . $theme->checksum . '.png';

		if(is_readable($path) === false) {
			$path = 'http://placehold.it/350x175';
		}

		Response::header('Content-Type', 'image/png');
		Response::content(file_get_contents($path));
	}

	public function preview($id) {
		$theme = Themes::find(array('id' => $id, 'status' => 'approved'));
		$path = BASE_PATH . 'previews/' . $theme->checksum . '.png';

		if(is_readable($path) === false) {
			$path = 'http://placehold.it/800x600';
		}

		Response::header('Content-Type', 'image/png');
		Response::content(file_get_contents($path));
	}

}