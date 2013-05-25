<?php defined('SYSPATH') or die('No direct script access.');

return array(
	'name' => NULL,
	'repository' => NULL,
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
