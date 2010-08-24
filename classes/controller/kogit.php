<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Kogit extends Controller {
	
	public $view,
          $config;
	
	public function before()
	{
		parent::before();
		
		$this->template = new View('kogit/default');
		$this->view = new View('kogit/block.empty');
		$this->config = Kohana::config("kogit");
		
		$this->git = new Model_Kogit_Git;
	}
	
	public function action_index()
	{
		$this->request->redirect('kogit/tree/head');
	}
	
	public function uri($uri=NULL)
	{
		$uri = explode('/', $uri);
		$sum = $uri[0];
		unset($uri[0]);
		return array($sum, implode('/', $uri));
	}
	
	public function after()
	{
		parent::after();
		
		View::set_global('path', Kohana::$base_url.'kogit/');
		View::set_global('controller', $this->request->controller);
		View::set_global('action', $this->request->action);
		View::set_global('project', $this->config->project);
		
		if (isset($this->view))
		{
			$this->template->view = $this->view;
		}
		
		$this->request->response = $this->template;
	}
}
