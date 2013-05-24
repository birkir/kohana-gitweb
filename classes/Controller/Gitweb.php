<?php defined('SYSPATH') or die('No direct script access.');

use GitElephant\Repository;

class Controller_Gitweb extends Controller_Template {

	public $template = 'gitweb/template';

	public $view;

	public $config;

	public $repository;

	public $reference;

	public $reference_type;

	public $path;

	public $tags = array();

	public $branches = array();

	public function before()
	{
		parent::before();

		if ($this->request->action() === 'media')
		{
			// Do not template media files
			$this->auto_render = FALSE;
		}
		else
		{
			// Load gitweb configuration
			$this->config = Kohana::$config->load('gitweb');

			// Create markdown instance
			$this->markdown = new Markdown_Parser();

			// Create Repository instance
			$this->repository = Repository::open($this->config['repository']);

			// Get current ref
			$parameters = explode('/', $this->request->param('ref', 'master'));

			// Get all branches
			$this->branches = $this->repository->getBranches(TRUE);

			// Get all tags
			foreach ($this->repository->getTags() as $tag)
			{
				$this->tags[] = $tag->getName();
			}

			// Loop through url parts
			foreach ($parameters as $i => $param)
			{
				// Join at current index for reference
				$this->reference = implode('/', array_slice($parameters, 0, $i + 1));

				// Join rest of uri as path
				$this->path = implode('/', array_slice($parameters, $i + 1));

				// Detect branch
				if (in_array($this->reference, $this->branches))
				{
					$this->reference_type = 'branch';
				}

				// Detect tag
				if (in_array($this->reference, $this->tags))
				{
					$this->reference_type = 'tag';
				}

				// Detect hash
				if (strlen($this->reference) === 40)
				{
					$this->reference_type = 'tree';
				}

				// Break on found
				if (isset($this->reference_type))
				{
					break;
				}
			}

			// Get absolute reference
			$this->reference = (strlen($this->reference) === 40) ? $this->repository->getCommit($this->reference) : $this->reference;

			// Fix null path
			$this->path = ! empty($this->path) ? $this->path : NULL;

			// Add some variables to all views
			View::set_global('repository', $this->repository);
			View::set_global('reference', $this->reference);
			View::set_global('path', $this->path);
			View::set_global('reference_type', $this->reference_type);
			View::set_global('action', $this->request->action());
			View::set_global('reponame', 'kohana-app-places');

			// Process menu
			$this->template->menu = $this->menu();
		}
	}

	public function menu()
	{
		$items = array(
			array(
				'attr' => array(),
				'acts' => array('tree', 'blob', 'raw'),
				'path' => URL::site('gitweb/tree/'.$this->reference),
				'name' => __('Files')
			),
			array(
				'attr' => array(),
				'acts' => array('commits', 'commit'),
				'path' => URL::site('gitweb/commits/'.$this->reference),
				'name' => __('Commits')
			),
			array(
				'attr' => array(),
				'acts' => array('branches'),
				'path' => URL::site('gitweb/branches'),
				'name' => __('Branches').' <span class="label">'.count($this->branches).'</span>'
			),
			array(
				'attr' => array('class' => 'pull-right'),
				'acts' => array('tags'),
				'path' => URL::site('gitweb/tags'),
				'name' => __('Tags').' <span class="label">'.count($this->tags).'</span>'
			)
		);

		foreach ($items as $i => $item)
		{
			if (in_array($this->request->action(), $item['acts']))
			{
				$items[$i]['attr']['class'] = ( ! empty($item['attr']['class']) ? $item['attr']['class'].' ' : NULL).'active';
			}
		}

		return $items;
	}

	/**
	 * Process media files statically
	 *
	 * @return void
	 */
	public function action_media()
	{
		// Get the file path from the request
		$file = $this->request->param('file');

		// Find the file extension
		$ext = pathinfo($file, PATHINFO_EXTENSION);

		// Remove the extension from the filename
		$file = substr($file, 0, -(strlen($ext) + 1));

		if ($file = Kohana::find_file('media/gitweb', $file, $ext))
		{
			// Check if the browser sent an "if-none-match: <etag>" header, and tell if the file hasn't changed
			$this->check_cache(sha1($this->request->uri()).filemtime($file));

			// Send the file content as the response
			$this->response->body(file_get_contents($file));

			// Set the proper headers to allow caching
			$this->response->headers('content-type',  File::mime_by_ext($ext));
			$this->response->headers('last-modified', date('r', filemtime($file)));
		}
		else
		{
			// Return a 404 status
			$this->response->status(404);
		}
	}

	public function action_tree()
	{
		// Setup view
		$this->view = View::factory('gitweb/tree')
		->bind('tree', $tree)
		->bind('files', $files)
		->bind('commit', $commit)
		->bind('readme', $readme);

		// Readmes
		$readme = NULL;
		$readmes = array('readme.md', 'readme.txt', 'readme');

		// Create Git Tree
		$tree = $this->repository->getTree($this->reference, $this->path);

		// Iteratable array
		$files = array();

		// Loop through files
		foreach ($tree as $item)
		{
			// Create file path
			$filePath = $item->getName();

			if ($item->getPath())
			{
				// Prepend file path
				$filePath = $item->getPath().DIRECTORY_SEPARATOR.$filePath;
			}

			if ( ! $readme AND in_array(UTF8::strtolower($item->getName()), $readmes))
			{
				// Get blob contents
				$readme = $this->repository->outputRawContent($item, $this->reference);

				if (substr($item->getName(), -3) === '.md')
				{
					// Parse markdown
					$readme = Markdown($readme);
				}
			}

			// Push file to array
			$files[] = array(
				'name' => $item->getName(),
				'type' => $item->getType(),
				'uri' => URL::site('gitweb/'.$item->getType().'/'.$this->reference.'/'.$filePath),
				'commit' => $this->repository->getLog($this->reference, $filePath, 1)->first()
			);
		}

		// Get commit from repository
		$commit = $this->repository->getLog($this->reference, $this->path, 1)->first();
	}

	public function action_blob()
	{
		$this->view = View::factory('gitweb/blob')
		->bind('tree', $tree);

		$tree = $this->repository->getTree($this->reference, $this->path);
	}

	public function action_raw() {}
	public function action_blame() {}

	public function action_commits()
	{
		$this->view = View::factory('gitweb/commits')
		->bind('commits', $commits)
		->bind('page', $page)
		->bind('limit', $limit);

		$page = Arr::get($this->request->query(), 'page', 1);
		$limit = 30;
		$offset = ($page * $limit) - $limit;

		$commits = $this->repository->getLog($this->reference, $this->path, $limit, $offset);
	}

	public function action_commit()
	{
		$this->view = View::factory('gitweb/commit')
		->bind('diff', $diff)
		->bind('stats', $stats)
		->bind('rowClass', $rowClass);

		$diff = $this->repository->getDiff($this->reference);

		$stats = array(
			'index'    => 0,
			'mode'     => 0,
			'new_file' => 0,
			'deleted'  => 0,
			'deleted_file' => 0,
			'line-added' => 0,
			'line-deleted' => 0,
			'line-unchanged' => 0
		);

		foreach ($diff as $diffObject) {
		        $stats[$diffObject->getMode()]++;
	        foreach ($diffObject as $diffChunk) {
                foreach ($diffChunk as $diffLine) {
                        $stats['line-'.$diffLine->getType()]++; } } }

		$rowClass = array(
		        'unchanged' => 'normal',
		        'added' => 'success',
		        'deleted' => 'danger'
		);
	}

	public function after()
	{
		if ($this->auto_render)
		{
			// Add view to template
			$this->template->view = $this->view;
		}

		return parent::after();
	}

} // End Gitweb
