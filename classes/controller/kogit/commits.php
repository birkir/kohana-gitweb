<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Repository commits list
 *
 * @package    Kogit
 * @category   Controllers
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Birkir R Gudjonsson
 * @license    http://kohanaphp.com/license
 */
class Controller_Kogit_Commits extends Controller_Kogit {
	
	private $per_page = 10;
	
	public function action_index()
	{
		$this->view = new View('smarty:kogit/commits/default');
		$this->view->project = $this->project;
		$commits = $this->models->git->commits();
		
		$this->view->pagination = Pagination::factory(array(
			'total_items'    => count($commits),
			'items_per_page' => $this->per_page,
		));
		
		$commits = array_slice($commits, $this->view->pagination->offset, $this->per_page);
		
		foreach ($commits as $k => $commit)
		{
			$commits[$k] = $this->models->git->commit($commit);
		}
		
		$this->view->commits = $commits;
		
	}

	public function action_tag($tag=NULL)
	{
	}

	public function action_branch($branch=NULL)
	{
	}

}
