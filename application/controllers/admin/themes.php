<?php

class Themes_controller extends Auth_controller {

	public function index() {
		$data['title'] = 'Themes';
		$data['themes'] = Themes::list_all();
		View::make('admin/themes/index', $data);
	}

	public function edit($id) {
		$data['title'] = 'Theme Edit';
		$data['theme'] = Themes::find(array('id' => $id));

		if(Input::method() == 'POST') {
			if(Themes::update($id)) {
				return Response::redirect('admin/themes');
			}
		}

		View::make('admin/themes/edit', $data);
	}

	public function upload() {
		$data['title'] = 'Theme Upload';

		if(Input::method() == 'POST') {
			if($id = Themes::upload()) {
				return Response::redirect('admin/themes/edit/' . $id);
			}
		}

		View::make('admin/themes/upload', $data);
	}

}