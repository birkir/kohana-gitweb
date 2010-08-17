<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Kogit extends Controller {
	
	public $view,
	       $project,
			 $actions = array(
				'index',
				'login'
			 );
	
	public function before()
	{
		parent::before();
		
		$this->template = new View('smarty:kogit/default');
		
		$this->project = $this->request->param('project');
		
		if ( ! $this->project)
		{
			$this->project = $this->request->action;
		}
		
		$this->models = (object) array();
		
		if ( ! empty($this->project) AND ! in_array($this->project, $this->actions))
		{
			$this->project = ORM::factory('kogit_project', array('alias' => $this->project));
			
			if ($this->project->loaded())
			{
				$this->models->git = new Model_Kogit_Git($this->project->project_id);
				
				if ($this->request->controller == 'kogit' AND $this->project->loaded())
				{
					
					$this->request->redirect(Kohana::$base_url.'kogit/'.$this->project->alias.'/tree/head');
				}
			}
			else
			{
				throw new Kohana_Exception('Project not found');
			}
		}
	}
	
	public function action_index()
	{
		$this->request->redirect('kogit/login');
	}
	
	public function action_login()
	{
		echo "foo";
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
