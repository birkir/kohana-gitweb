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
class Controller_Kogit_Commit extends Controller_Kogit {

	public function action_index()
	{
	}

	public function action_view($project=NULL, $sha1=NULL)
	{
		$this->view = new View('smarty:kogit/commit/default');
		$this->view->project = $this->project;
		$this->view->commit = $this->models->git->commit($sha1);
		
		$commit_from = isset($this->view->commit['parents'][0]) ? $this->view->commit['parents'][0] : str_repeat('0', 40);
		$commit_to = $this->view->commit['h'];
		
		$this->view->diff = $this->models->git->diff($commit_from, $commit_to);
	}

}
