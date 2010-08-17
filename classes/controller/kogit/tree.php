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

	public function action_index()
	{
		$this->view = new View('smarty:kogit/tree/default');
		$this->view->project = $this->project;
		$this->view->commit = $this->models->git->commit('HEAD');
		$this->view->tree = $this->models->git->tree();
	}
	
	public function action_head($project=NULL, $path='/')
	{
		$this->view = new View('smarty:kogit/tree/default');
		$this->view->project = $this->project;
		$this->view->commit = $this->models->git->commit('HEAD');
		$this->view->tree = $this->models->git->tree($path);
	}

	public function action_tag($tag=NULL)
	{
	}

	public function action_branch($branch=NULL)
	{
	}

}
