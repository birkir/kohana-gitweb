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

	/**
	 * Display current repository tree by hash
	 *
	 * @param	string	Hash to use
	 * @param	string	Directory to display
	 * @return	void
	 */
	public function action_index($hash=NULL, $path=NULL)
	{
		// Check if Markdown class has been loaded
		if ( ! class_exists('Markdown', FALSE))
		{
		        // Load Markdown support
		        require_once(Kohana::find_file('vendor', 'markdown/markdown'));
		}

		$path = empty($path) ? '/' : $path;
		
		$hash = (empty($hash) OR $hash == 'head') ? 'HEAD' : $hash;
		
		$this->view = new View('kogit/tree');
		
		$this->view->project_info = new View('kogit/block.project');
		
		$this->view->commit = new View('kogit/block.commit');
		$this->view->commit->commit = $this->git->commit($hash);
		
		$this->view->tree = $this->git->tree($path, $hash);
		
		$this->view->hash = $hash;
		
		// Check if markdown readme file was found
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
