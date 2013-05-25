<?php defined('SYSPATH') or die('No direct script access.');

use GitElephant\Repository;
use \Michelf\Markdown;

/**
 * Gitweb Controller
 *
 * @package Gitweb
 * @category Controller
 * @author Birkir Gudjonsson (birkir.gudjonsson@gmail.com)
 */
class Controller_Gitweb extends Controller_Template {

	/**
	 * Template file location
	 * @var string
	 */
	public $template = 'gitweb/template';

	/**
	 * Global controller variables
	 * @var mixed
	 */
	public $view,
	       $config,
	       $repository,
	       $reference,
	       $path;

	/**
	 * Extend controllers before function
	 *
	 * @return void
	 */
	public function before()
	{
		// Call the parent
		parent::before();

		// Load gitweb configuration
		$this->config = Kohana::$config->load('gitweb');

		// Get repository
		$this->repository = $this->config['repository'];

		// Set as docroot if not set
		if (empty($this->repository))
		{
			$this->repository = DOCROOT;
		}

		if (empty($this->name))
		{
			$this->name = basename($this->repository);
		}

		// Only do this on media
		if ($this->request->action() === 'media')
		{
			// Do not template media files
			$this->auto_render = FALSE;
		}
		else
		{
			// Create Repository instance
			$this->repository = Repository::open($this->repository);

			// Get current ref
			$parameters = explode('/', $this->request->param('ref', $this->repository->getMainBranch()->getName()));

			// Get all branches
			$branches = $this->repository->getBranches(TRUE, TRUE);

			// Loop through url parts
			foreach ($parameters as $i => $param)
			{
				// Join at current index for reference
				$this->reference = implode('/', array_slice($parameters, 0, $i + 1));

				// Join rest of uri as path
				$this->path = implode('/', array_slice($parameters, $i + 1));

				// Detect branch
				if ($this->repository->getTag($this->reference) OR in_array($this->reference, $branches) OR strlen($this->reference) === 40)
					break;
			}

			// Get absolute reference
			$this->reference = (strlen($this->reference) === 40) ? $this->repository->getCommit($this->reference) : $this->reference;

			// Fix null path
			$this->path = ! empty($this->path) ? $this->path : NULL;

			// Get action menu
			$this->template->menu = $this->config['actions'];

			// Loop through menu items
			foreach ($this->template->menu as $k => $item)
			{
				// Fix reference and path vars
				$this->template->menu[$k]['path'] = str_replace(array(':ref', ':path'), array($this->reference, $this->path), $item['path']);

				// Attach active parameter to item
				$this->template->menu[$k]['active'] = in_array($this->request->action(), explode(',', $item['triggers']));
			}

			// Add some variables to all views
			View::set_global('repository', $this->repository);
			View::set_global('reference', $this->reference);
			View::set_global('path', $this->path);
			View::set_global('action', $this->request->action());
			View::set_global('config', $this->config);
			View::set_global('reponame', $this->name);
		}
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

	/**
	 * Visualize repository tree at its current state
	 * and shows readme file if found.
	 * 
	 * @return void
	 */
	public function action_tree()
	{
		// Setup view
		$this->view = View::factory('gitweb/tree')
		->bind('tree', $tree)
		->bind('files', $files)
		->bind('commit', $commit)
		->bind('readme', $readme);

		// Create Git Tree
		try
		{
			$tree = $this->repository->getTree($this->reference, $this->path);
		}
		catch (Exception $e)
		{
			return $this->action_error();
		}

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

			// Check if readme file is found
			if ( ! $readme AND in_array(UTF8::strtolower($item->getName()), array('readme.md', 'readme.txt', 'readme')))
			{
				// Get blob contents
				$readme = $this->repository->outputRawContent($item, $this->reference);

				// Check for markdown extension
				if (substr($item->getName(), -3) === '.md')
				{
					// Parse markdown
					$readme = Markdown::defaultTransform($readme);
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

	/**
	 * Render a given blob file with syntax highligting.
	 *
	 * @return void
	 */
	public function action_blob()
	{
		// Setup view
		$this->view = View::factory('gitweb/blob');

		// Get repository tree at given reference and path
		$this->view->tree = $this->repository->getTree($this->reference, $this->path);

		// Get the tree's state blob
		$this->view->blob = $this->view->tree->getBlob();

		// Get content of blob at given reference
		$this->view->content = $this->repository->outputRawContent($this->view->blob, $this->reference);
	}

	/**
	 * Dump raw content of blob file at given reference.
	 * 
	 * @return void
	 */
	public function action_raw()
	{
		// Disable auto render
		$this->auto_render = FALSE;

		// Get repository tree at given reference and path
		$tree = $this->repository->getTree($this->reference, $this->path);

		// Set content type to plain text for better reading
		$this->response->headers('content-type', 'text/plain');

		// Render blob contents
		$this->response->body($this->repository->outputRawContent($tree->getBlob(), $this->reference));
	}

	/**
	 * List commits for repository at given reference.
	 * 
	 * @return void
	 */
	public function action_commits()
	{
		// Setup view
		$this->view = View::factory('gitweb/commits')
		->bind('page', $page)
		->bind('limit', $limit);

		// Get page with query string
		$page = Arr::get($this->request->query(), 'page', 1);

		// Set limit
		$limit = 30;

		// Calculate offset for page
		$offset = ($page * $limit) - $limit;

		// Attach list of commits to view
		$this->view->commits = $this->repository->getLog($this->reference, $this->path, $limit, $offset);
	}

	/**
	 * Visualize the selected commit with changes made to the files.
	 * 
	 * @return [type] [description]
	 */
	public function action_commit()
	{
		$this->view = View::factory('gitweb/commit')
		->bind('commit', $commit)
		->bind('diff', $diff)
		->bind('stats', $stats);

		// Get last commit from repository
		$commit = $this->repository->getLog($this->reference, $this->path, 1)->first();

		// Setup the diff
		$diff = $this->repository->getDiff($this->reference);

		// Initialize statistics array
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

		// Loop through diff
		foreach ($diff as $diffObject)
		{
			// Iterate index, mode, new_file and deleted states.
			$stats[$diffObject->getMode()]++;

			// Loop through chucnks
			foreach ($diffObject as $diffChunk)
			{
				// Loop through lines in chunk
				foreach ($diffChunk as $diffLine)
				{
					// Iterate lines added and deleted
					$stats['line-'.$diffLine->getType()]++;
				}
			}
		}

		// Row classes converter
		$this->view->rowClass = array(
		        'unchanged' => 'normal',
		        'added' => 'success',
		        'deleted' => 'danger'
		);
	}

	/**
	 * List available branches
	 * 
	 * @return void
	 */
	public function action_branches()
	{
		// Setup view
		$this->view = View::factory('gitweb/branches');

		// Get list of branches from repository
		$this->view->branches = $this->repository->getBranches();
	}

	/**
	 * List available tags
	 * 
	 * @return void
	 */
	public function action_tags()
	{
		// Setup view
		$this->view = View::factory('gitweb/tags');

		// Get list of available tags
		$this->view->tags = $this->repository->getTags();
	}

	/**
	 * Branch error
	 * 
	 * @return 
	 */
	public function action_error()
	{
		// Setup view 
		$this->view = View::factory('gitweb/error');
	}

	/**
	 * Extend default controller after function
	 * 
	 * @return parent
	 */
	public function after()
	{
		if ($this->auto_render)
		{
			// Add view to template
			$this->template->view = $this->view;
		}

		// Return parent 
		return parent::after();
	}

} // End Gitweb
