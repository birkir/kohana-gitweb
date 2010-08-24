<?php defined('SYSPATH') OR die('No direct access allowed.');

return array
(
	'git' => '/usr/bin/git',
	'repository' => '/var/www/kogit.forritun.org/modules/kogit',
	'commit' => array(
		'message' => array(
			'maxlength' => 128
		)
	),
	'project' => array(
		'title' => 'KoGit',
		'description' => 'Git Web Interface as KO3 module',
		'website' => 'http://kogit.forritun.org/kogit'
	)
);
