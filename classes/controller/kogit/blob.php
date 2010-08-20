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
	
	public function action_index($hash=NULL, $file=NULL)
	{
		$hash = (empty($hash) OR $hash == 'head') ? 'HEAD' : $hash;
		
		$this->view = new View('smarty:kogit/blob/default');
		
		$this->view->project = new View('smarty:kogit/misc/project');
		
		$this->view->commit = new View('smarty:kogit/misc/commit');
		$this->view->commit->commit = $this->git->commit($hash);
		
		$this->view->blob = $this->git->blob($file, TRUE);
	}

}
