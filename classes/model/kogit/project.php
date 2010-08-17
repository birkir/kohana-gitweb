<?php defined('SYSPATH') or die('No direct script access.');

class Model_Kogit_Project extends ORM {
	
	protected $_table_name = 'projects';
	protected $_primary_key = 'project_id';
	protected $_primary_val = 'title';
	
}
