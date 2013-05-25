<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'name' => 'kohana-gitweb',
	'repository' => '/var/www/forritun.org/eat.forritun.org',
	'actions' => array(
		'Files' => array(
			'path' => 'tree/:ref',
			'triggers' => 'tree,blob,raw'
		),
		'Commits' => array(
			'path' => 'commits/:ref',
			'triggers' => 'commits,commit'
		),
		'Branches' => array(
			'path' => 'branches',
			'triggers' => 'branches'
		),
		'Tags' => array(
			'path' => 'tags',
			'triggers' => 'tags'
		)
	)
);
