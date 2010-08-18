<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Repository files and directories tree
 *
 * @package    Kogit
 * @category   Controllers
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Birkir R Gudjonsson
 * @license    http://kohanaphp.com/license
 */
class Controller_Kogit_Tree extends Controller_Kogit {

	public function action_index($project=NULL)
	{
		$this->request->redirect(Kohana::$base_url.'kogit/'.$project.'/tree/head');
	}
	
	public function action_head($project=NULL, $path='/')
	{
		$this->view = new View('smarty:kogit/tree/default');
		$this->view->project = $this->project;
		$this->view->commit = $this->models->git->commit('HEAD');
		$this->view->tree = $this->models->git->tree($path);
		$this->view->readme = $this->models->git->blob('README.md');
		if ( ! $this->view->readme)
		{
			$this->view->readme = $this->models->git->blob($path.'README');
		}
	}
	
	public function action_sum($project=NULL, $sum=NULL)
	{
		$this->view = new View('smarty:kogit/tree/default');
		$this->view->project = $this->project;
		$this->view->commit = $this->models->git->commit('HEAD');
		$this->view->tree = $this->models->git->tree($sum);
	}

	public function action_tag($tag=NULL)
	{
	}

	public function action_branch($branch=NULL)
	{
	}

}
