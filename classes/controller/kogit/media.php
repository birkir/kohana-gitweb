<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Kogit media will provide the system all resources, images, stylesheets,
 * javascript files and any other kind of files used as media.
 *
 * @package    Kogit
 * @category   Controllers
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Birkir R Gudjonsson
 * @license    http://kohanaphp.com/license
 */
class Controller_Kogit_Media extends Controller {
	
	protected $_module = 'kogit/';
	protected $_directory = 'media/';
	protected $_minify = 'css,js';
	protected $_gzip = TRUE;
	
	public function action_index()
	{
		$this->request->response = '404 File not found';
	}
	
	public function action_img($project=NULL, $file='')
	{
		$this->passthru($this->process($file));
	}
	
	public function action_css($project=NULL, $file='')
	{
		$this->passthru($this->process($file));
	}
	
	public function action_js($project=NULL, $file='')
	{
		$this->passthru($this->process($file));
	}
	
	/**
	 * Process certein file through minify, gzip, cache, etc.
	 *
	 * @param	string	Path to file
	 * @return	string	Path to file
	 */
	public function process($file=NULL)
	{
		$file = MODPATH.$this->_module.$this->_directory.$this->request->action.'/'.$file;
		
		if ( ! file_exists($file))
		{
			$this->request->response = '404 File not found';
			return false;
		}
		
		if (in_array($this->request->action, explode(',', $this->_minify)))
		{
			$file = $this->minify($file, $this->request->action);
		}
		
		if ($this->_gzip == TRUE)
		{
			$file = $this->gzip($file);
		}
		
		return $file;
	}

	/**
	 * Minify javascript or css files and cache it.
	 * 
	 * @param	string	Path to file to minify
	 * @return	string	Path to minified and cached file
	 */
	public function minify($file=NULL, $type='css')
	{
		if ( ! is_file($file))
		{
			throw new Kohana_Exception('404 File not found');
		}
		
		$this->minified = MODPATH.$this->_module.'cache/minify/'.md5_file($file).substr($file,strrpos($file,'.'));
		
		if ( ! file_exists($this->minified))
		{
			$file_content = file_get_contents($file);
			
			$min_content = Minify::factory($type)->set($file_content)->min();
			
			if ($type == 'css')
			{
				$min_content = str_replace('url(/..', 'url(..', $min_content);
			}
			
			$fh = fopen($this->minified, 'w+');
			fwrite($fh, $min_content);
			fclose($fh);
		}
		
		return $this->minified;
	}
	
	/**
	 * Pass the file through browser using the correct mime type.
	 *
	 * @param	string	Path to file
	 */
	public function passthru($file=NULL, $gzip=FALSE)
	{
		
		if ( ! is_file($file))
		{
			throw new Kohana_Exception('404 File not found');
		}
		
		if ($this->request->accept_encoding('gzip') AND $this->_gzip == TRUE)
		{
			$this->request->headers['Content-Encoding'] = 'gzip';
		}
		
		$this->request->headers['Content-Type'] = File::mime_by_ext(substr($file,strrpos($file,'.')+1));
		$this->request->headers['Content-length'] = filesize($file);
		$this->request->headers['Last-Modified']  = date('r', filemtime($file));
		
		if (isset($cache))
		{
			$this->request->headers['Cache-Control'] = 'must-revalidate';
			$this->request->headers['Expires'] = gmdate("D, d M Y H:i:s", time() + 86400).' GMT';
		}
		
		$this->request->send_headers();
		
		$image = @ fopen($file, 'rb');
		if ($image)
		{
			fpassthru($image);
			exit;
		}
	}
	
	/**
	 * Gzip file and cache it
	 *
	 * @param	string	Path to file
	 * @return	string	Path to gzipped file
	 */
	public function gzip($file=NULL)
	{
		$this->cached = MODPATH.$this->_module.'cache/media/'.md5_file($file).substr($file,strrpos($file,'.'));
		
		if ( ! is_file($file))
		{
			throw new Kohana_Exception('404 File not found');
		}
		
		if ( ! file_exists($this->cached))
		{
			$fh = fopen($this->cached, 'w+');
			fwrite($fh, gzencode(file_get_contents($file)));
			fclose($fh);
		}
		
		return $this->cached;
	}
}