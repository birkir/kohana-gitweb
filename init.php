<?php defined('SYSPATH') or die('No direct script access.');

Route::set('kogit', 'kogit/(<controller>(/<action>(/<id>)))', array('id' => '.+'))
        ->defaults(array(
		'directory'  => 'kogit',
                'controller' => 'home',
                'action'     => 'index',
        ));
