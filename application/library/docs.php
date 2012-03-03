<?php

class Docs {

	public static function list_all($params = array()) {
		$query = Query::make()->select('*')->from('docs');

		if(isset($params['parent'])) {
			$query->where('parent', $params['parent']);
		}

		return $query->results();
	}
	
	public static function find($where = array()) {
		$query = Query::make()->select('*')->from('docs');

		foreach($where as $key => $value) {
			$query->where($key, $value);
		}

		return $query->row();
	}

	public static function menu() {
		// start with root pages
		$menu = array();
		$pages = static::list_all(array('parent' => 0));

		// get sub pages
		foreach($pages as $page) {
			$page->children = static::list_all(array('parent' => $page->id));
			$menu[] = $page;
		}

		return $menu;
	}

	public static function update($id) {
		$post = input::post(array('html', 'example'));

		Query::make()->update('docs', array(
			'html' => Str::entities($post['html']),
			'example' => Str::entities($post['example'])
		))->where('id', $id)->go();

		return true;
	}

}
