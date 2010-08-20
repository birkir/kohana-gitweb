<?php defined('SYSPATH') or die('No direct script access.');

class Model_Kogit_Git extends Model {
	
	public $repository,
	       $commits = array(),
			 $files = array();
	
	/**
	 * Find commit
	 */
	public function commit($sha1='HEAD')
	{
		$config = Kohana::config("kogit");
		
		if ( ! isset($this->commits[$sha1]))
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
						$info['message'] = substr($line, 4, $config->commit['message']['maxlength']);
						$info['message_firstline'] = substr($line, 4);
					}
				}
				else if (preg_match('/^[0-9a-f]{40}$/', $line) > 0)
				{
					$info['h'] = $line;
				}
			}
			
			$this->commits[$sha1] = $info;
		}
		else
		{
			$info = $this->commits[$sha1];
		}
		
		return $info;
	}
	
	/**
	 * Find all commits
	 */
	function commits()
	{
		$output = $this->run('log | cat');
		
		$commits = array();
		
		foreach($output as $line)
		{
			if (substr(trim($line), 0, 6) == 'commit')
			{
				$commits[] = substr(trim($line), -40);
			}
		}
		
		return $commits;
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
	public function tree($dir='/', $ref='HEAD', $info=TRUE)
	{
		$tree = array();
		
		$output = $this->run('ls-tree '.$ref.' '.($dir=='/' ? '.' : $dir.'/.'));
		
		foreach ($output as $line)
		{
			$parts = preg_split('/\s+/', $line, 4);
			
			$file = explode('/', $parts[3]);
			
			$_tree = array(
				'file' => $file[count($file)-1],
				'name' => $parts[3],
				'mode' => $parts[0],
				'type' => $parts[1],
				'hash' => $parts[2]
			);
			
			if ($info==TRUE)
			{
				$_tree['info'] = $this->commit($this->file_commit($parts[3]));
			}
			
			$tree[] = $_tree;
			
		}
		
		return $tree;
	}
	
	public function diff($from, $to, $highlight=FALSE)
	{
		$output = $this->run('diff '.$from.'..'.$to);
		
		$files = array();
		foreach ($output as $line)
		{
			if (preg_match('#diff \-\-git a\/(.*?) b\/(.*?)!exit#s', $line.'!exit', $f))
			{
				if (isset($file))
				{
					$files[] = $file;
				}
				$i = 0;
				$count = -1;
				$file = array(
					'name' => $f[2],
					'diff' => array(),
					'deleted' => 0,
					'created' => 0
				);
				$lnr = 0;
				$rnr = 0;
			}
			
			if ($i == 1)
			{
				if (substr($line,0,8) == 'new file')
				{
					$file['type'] = 'created';
				}
				elseif (substr($line,0,12) == 'deleted file')
				{
					$file['type'] = 'deleted';
				}
				else
				{
					$file['type'] = 'edited';
				}
			}
			
			if (($i == 1 OR $i == 2) AND substr($line,0,6) == 'index ')
			{
				$count = $i + 2;
			}
			
			if(preg_match("#\@\@ \-([0-9]{1,9}).*?\+([0-9]{1,9}).*?\@\@#s", $line, $_count))
			{
				$lnr = $_count[1]-1;
				$rnr = $_count[2]-1;
				$file['diff'][] = array('lnr' => '...', 'rnr' => '...', 'type' => '@', 'line' => $line);
			}
			
			else if ($i > $count AND $count != -1)
			{
				$type = '';
				if (substr($line,0,1) == '+')
				{
					$file['created']++;
					$type = '+';
					$rnr++;
				}
				else if (substr($line,0,1) == '-')
				{
					$file['deleted']++;
					$type = '-';
					$lnr++;
				}
				else
				{
					$lnr++;
					$rnr++;
				}
				
				$line = str_replace(array('<', '>', "\t"), array('&lt;', '&gt;', '  '), $line);
				
				$file['diff'][] = array('lnr' => $lnr, 'rnr' => $rnr, 'type' => $type, 'line' => $line);
			}
			
			$i++;
		}
		
		$files[] = $file;
		
		return $files;
	}
	
	/**
	 * Check latest commit of file
	 */
	public function file_commit($file=NULL)
	{
		if ( ! isset($this->files[$file]))
		{
			$output = $this->run('log '.$file.' | cat');
			if (isset($output[0]))
			{
				$this->files[$file] = substr($output[0], -40);
			}
			else
			{
				return FALSE;
			}
		}
		
		return $this->files[$file];
	}
	
	public function blob($file=NULL, $highlight=TRUE, $hash='HEAD')
	{
		$config = Kohana::config("kogit");
		
		$language = substr($file, strrpos($file, '.')+1);
		
		switch($language)
		{
			case 'tpl':
				$language = 'smarty'; break;
			case 'js':
				$language = 'javascript'; break;
			default:
				$language = $language;
		}
		
		$output = $this->run('show '.$hash.':'.$file.' | cat');
		
		$data = implode("\n", $output);
		
		if (empty($data))
		{
			return FALSE;
		}
		
		if ($highlight == TRUE)
		{
			$data = new GeSHi($data, $language);
			$data->enable_line_numbers(GESHI_NORMAL_LINE_NUMBERS);
			$data->set_line_style('background:#ffffff; color:#aaaaaa;');
			$data = $data->parse_code();
		}
		
		return $data;
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
		$config = Kohana::config("kogit");
		
		$cmd = 'cd '.escapeshellarg($config->repository).' && '.$config->git.' --git-dir='.escapeshellarg($config->repository.'/.git').' '.$command;
		
		$ret = 0;
		$output = '';
		@exec($cmd, $output, $ret);
		return $output;
	}
	
}
