<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Kogit_Home extends Controller {

	public function action_index()
	{
		$this->request->response = "Hello world";
	}

}
