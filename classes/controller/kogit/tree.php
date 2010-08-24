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

	public function action_index($hash=NULL, $path=NULL)
	{
		$path = empty($path) ? '/' : $path;
		
		$hash = (empty($hash) OR $hash == 'head') ? 'HEAD' : $hash;
		
		$this->view = new View('kogit/tree');
		
		$this->view->project_info = new View('kogit/block.project');
		
		$this->view->commit = new View('kogit/block.commit');
		$this->view->commit->commit = $this->git->commit($hash);
		
		$this->view->tree = $this->git->tree($path, $hash);
		
		$this->view->hash = $hash;
		
		if ($readme = $this->git->blob('README.md', FALSE))
		{
			$this->view->readme_md = Markdown($readme);
		}
		else
		{
			$this->view->readme = $this->git->blob($extra.'README', FALSE);
		}
		
	}

}
