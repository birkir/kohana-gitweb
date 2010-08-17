<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Kogit extends Controller {

	public function before()
	{
		parent::before();
	}
	
	public function action_index()
	{
		$this->request->redirect('kogit/login');
	}

	public function after()
	{
		parent::after();
		
		View::set_global('path', '/kogit/');
		
		$this->request->response = $this->template;
	}
}
