<?php

class Docs_controller {

	public function index() {
		$data['title'] = 'Docs';
		View::make('docs/index', $data);
	}

	public function view() {
		// get last segment and used it as bait
		$segments = func_get_args();
		$slug = end($segments);

		$data['page'] = ($page = Docs::find(array('slug' => $slug)));
		$data['title'] = $page->title;

		View::make('docs/view', $data);
	}

	public function edit($id) {

		if(Input::method() == 'POST') {
			if(Docs::update($id)) {
				return Response::redirect('edit/' . $id);
			}
		}

		$data['page'] = ($page = Docs::find(array('id' => $id)));
		$data['title'] = $page->title;
		$data['url'] = 'docs/' . ($page->parent ? Docs::find(array('id' => $page->parent))->slug . '/' : '') . $page->slug;

		View::make('docs/edit', $data);
	}

}