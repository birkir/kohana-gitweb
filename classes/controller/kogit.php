<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Kogit extends Controller {
	
	public $view;
	
	public function before()
	{
		parent::before();
		
		$this->template = new View('smarty:kogit/default');
	}
	
	public function action_index()
	{
		$this->request->redirect('kogit/login');
	}

	public function after()
	{
		parent::after();
		
		View::set_global('path', Kohana::$base_url.'kogit/');
		
		if (isset($this->view))
		{
			$this->template->view = $this->view;
		}
		
		$this->request->response = $this->template;
	}
}
