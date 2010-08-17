<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Kogit_Login extends Controller_Kogit {

	public function action_index()
	{
		$this->template = new View('smarty:kogit/login');
	}
}
