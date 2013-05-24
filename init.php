<?php defined('SYSPATH') or die('No direct script access.');

// Static file serving (CSS, JS, images)
Route::set('gitweb/media', 'gitweb-media(/<file>)', array('file' => '.+'))
	->defaults(array(
		'controller' => 'Gitweb',
		'action'     => 'media',
		'file'       => NULL,
	));

// Gitweb pages, in modules
Route::set('gitweb', 'gitweb(/<action>(/<ref>))', array(
		'ref' => '.+'
	))
	->defaults(array(
		'controller' => 'Gitweb',
		'action'     => 'tree'
	));

// Include git library
include_once Kohana::find_file('vendor', 'autoload');

// Simple autoloader used to encourage PHPUnit to behave itself.
class Markdown_Autoloader {
	public static function autoload($class)
	{
		if ($class == 'Markdown_Parser' OR $class == 'MarkdownExtra_Parser')
		{
			include_once Kohana::find_file('vendor', 'markdown/markdown');
		}
	}
}

// Register the autoloader
spl_autoload_register(array('Markdown_Autoloader', 'autoload'));
