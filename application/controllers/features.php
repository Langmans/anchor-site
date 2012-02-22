<?php

class Features_Controller extends Base_Controller {

	public function action_index()
	{
		return View::make('features.index');
	}

}