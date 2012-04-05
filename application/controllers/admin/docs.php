<?php

class Docs_controller extends Auth_controller {

	public function index() {
		$data['title'] = 'Docs';
		View::make('admin/docs/index', $data);
	}

	public function edit($id) {
		$data['title'] = 'Docs';
		$data['doc'] = Docs::find(array('id' => $id));

		if(Input::method() == 'POST') {
			if(Docs::update($id)) {
				return Response::redirect('admin/docs/edit/' . $id);
			}
		}

		View::make('admin/docs/edit', $data);
	}

}