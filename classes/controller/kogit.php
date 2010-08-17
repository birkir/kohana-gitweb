<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Kogit extends Controller {
	
	public $view,
	       $project;
	
	public function before()
	{
		parent::before();
		
		$this->template = new View('smarty:kogit/default');
		
		$this->project = $this->request->param('project');
		
		$this->models = (object) array();
		
		if ( ! empty($this->project))
		{
			$this->project = ORM::factory('kogit_project', array('alias' => $this->project));
			$this->models->git = new Model_Kogit_Git($this->project->project_id);
		}
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
