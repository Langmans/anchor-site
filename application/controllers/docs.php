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

		if(($page = Docs::find(array('slug' => $slug))) === false) {
			return Response::content(View::make('errors/error_404'), 404);
		}

		$data['page'] = $page;
		$data['title'] = $page->title;
		$data['user'] = Users::authed();

		View::make('docs/view', $data);
	}

}