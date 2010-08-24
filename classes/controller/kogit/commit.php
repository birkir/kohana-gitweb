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

	public function action_index($hash=NULL)
	{
		$hash = (empty($hash) OR $hash == 'head') ? 'HEAD' : $hash;
		
		$this->view = new View('kogit/commit');
		$this->view->project_info = new View('kogit/block.project');
		
		$this->view->commit = new View('kogit/block.commit');
		$this->view->commit->commit = $this->git->commit($hash);
		
		$commit_from = isset($this->view->commit->commit['parents'][0]) ? $this->view->commit->commit['parents'][0] : str_repeat('0', 40);
		$commit_to = $this->view->commit->commit['h'];
		
		$this->view->diff = $this->git->diff($commit_from, $commit_to, TRUE);
		
	}

}
