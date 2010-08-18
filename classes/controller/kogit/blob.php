<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Repository commit view
 *
 * @package    Kogit
 * @category   Controllers
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Birkir R Gudjonsson
 * @license    http://kohanaphp.com/license
 */
class Controller_Kogit_Blob extends Controller_Kogit {
	
	public function action_index(){}
	
	// get file in tag
	public function action_tag(){}
	
	// get file in branch
	public function action_branch(){}
	
	// get file in head
	public function action_head($project=NULL, $file=NULL)
	{
		$this->view = new View('smarty:kogit/blob/default');
		$this->view->project = $this->project;
		$this->view->commit = $this->models->git->commit('HEAD');
		$this->view->blob = $this->models->git->blob($file);
	}
	
	public function action_view($project=NULL, $uri=NULL)
	{
		list($sha1, $path) = $this->uri($uri);
		$this->view = new View('smarty:kogit/blob/default');
		$this->view->project = $this->project;
		$this->view->commit = $this->models->git->commit($sha1);
		$this->view->blob = $this->models->git->blob($path);
	}

}
