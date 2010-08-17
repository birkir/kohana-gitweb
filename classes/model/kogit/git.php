<?php defined('SYSPATH') or die('No direct script access.');

class Model_Kogit_Git extends Model {
	
	public $config, $git, $repository;
	
	public function __construct($id=0)
	{
		$this->config = Kohana::config("kogit");
		
		$this->git = $this->config->git;
		
		if ($id == 0)
		{
			throw new Kohana_Exception('No project id defined');
		}
		
		$this->repository = ORM::factory('kogit_project', $id);
		
		if ( ! $this->repository->loaded() )
		{
			throw new Kohana_Exception('Project was not found!');
		}
		
	}
	
	/**
	 * Find commit
	 */
	public function commit($sha1=NULL)
	{
		$output = $this->run('rev-list --header --max-count=1 '.$sha1);
		
		$info = array('message_full' => '');
		
		$pattern = '/^(author|committer) ([^<]+) <([^>]*)> ([0-9]+) (.*)$/';
		
		foreach ($output as $line)
		{
			if (substr($line, 0, 4) === 'tree')
			{
				$info['tree'] = substr($line, 5);
			}
			else if (substr($line, 0, 6) === 'parent')
			{
				$info['parents'][] = substr($line, 7);
			}
			else if (preg_match($pattern, $line, $matches) > 0)
			{
				$info[$matches[1] .'_name'] = $matches[2];
				$info[$matches[1] .'_mail'] = $matches[3];
				$info[$matches[1] .'_stamp'] = $matches[4] + ((intval($matches[5]) / 100.0) * 3600);
				$info[$matches[1] .'_timezone'] = $matches[5];
				$info[$matches[1] .'_utcstamp'] = $matches[4];
			}
			else if (substr($line, 0, 4) === '    ' OR (strlen($line) == 0 AND isset($info['message'])))
			{
				$info['message_full'] .= substr($line, 4) ."\n";
				
				if ( ! isset($info['message']))
				{
					$info['message'] = substr($line, 4, $this->config->commit['message']['maxlength']);
					$info['message_firstline'] = substr($line, 4);
				}
			}
			else if (preg_match('/^[0-9a-f]{40}$/', $line) > 0)
			{
				$info['h'] = $line;
			}
		}
		
		return $info;
	}
	
	/**
	 * Find tags
	 */
	public function tags()
	{
		$output = $this->run('show-ref --tags');
		
		$tags = array();
		
		foreach ($output as $line)
		{
			$code = substr($line, 41);
			$tmp = explode('/', $code);
			$title = array_pop($tmp);
			$tags[] = array(
				'sha1' => substr($line, 0, 40),
				'title' => $title
			);
		}
		
		return $tags;
	}
	
	/**
	 * Get tree
	 */
	public function tree($dir='/', $ref='HEAD')
	{
		$tree = array();
		
		$output = $this->run('ls-tree '.$ref.' '.($dir=='/' ? '.' : $dir.'/.'));
		
		foreach ($output as $line)
		{
			$parts = preg_split('/\s+/', $line, 4);
			$tree[] = array(
				'name' => $parts[3],
				'mode' => $parts[0],
				'type' => $parts[1],
				'hash' => $parts[2]
			);
		}
	
		return $tree;
	}
	
	/**
	 * Find heads
	 */
	public function heads()
	{
		$output = $this->run('show-ref --heads');
		
		$heads = array();
		
		foreach ($output as $line)
		{
			$code = substr($line, 41);
			$tmp = explode('/', $code);
			$title = array_pop($tmp);
			$heads[] = array(
				'sha1' => substr($line, 0, 40),
				'title' => $title
			);
		}
		
		return $heads;
	}
	
	/**
	 * Search in repository
	 */
	public function search($type=NULL, $query=NULL)
	{
		$ret = array();
		
		switch ($type)
		{
			case 'change':
				$command = '-S ';
				break;
			
			case 'commit':
				$command = '-i --grep=';
				break;
			
			case 'author':
				$command = '-i --author=';
				break;
			
			case 'committer':
				$command = '-i --committer=';
				break;
			
			default:
				throw new Kohana_Exception('Unsupported search type');
		}
		
		$output = $this->run('log '.$command.escapeshellarg($query));
		
		foreach ($output as $line)
		{
			if (preg_match('/^commit (.*?)$/', $line, $matches))
			{
				$ret[] = $matches[1];
			}
		}
		
		return $ret;
	}
	
	/**
	 * Run git command
	 */
	private function run($command=NULL)
	{
		$cmd = $this->git.' --git-dir='.escapeshellarg($this->repository->path).' '.$command;
		$ret = 0;
		exec($cmd, $output, $ret);
		return $output;
	}
	
}
