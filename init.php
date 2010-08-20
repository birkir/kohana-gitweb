<?php defined('SYSPATH') or die('No direct script access.');

require_once('vendor/markdown.php');

Route::set('kogit/media', 'kogit/media(/<type>(/<file>))', array('file' => '.+'))
	->defaults(array(
		'project'    => '',
		'directory'  => 'kogit',
		'controller' => 'media',
		'action'     => 'process',
	));
	
Route::set('kogit', 'kogit/(<controller>(/<action>(/<id>(/<extra>))))', array('extra' => '.+'))
	->defaults(array(
		'project'    => '',
		'directory'  => 'kogit',
		'controller' => 'tree',
		'action'     => 'index',
	));