<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Repository issues view
 *
 * @package    Kogit
 * @category   Controllers
 * @author     Birkir R Gudjonsson
 * @copyright  (c) 2010 Birkir R Gudjonsson
 * @license    http://kohanaphp.com/license
 */
class Controller_Kogit_Issues extends Controller_Kogit {

	// Error page as there is no action defined
	public function action_index(){}

	// View issue and its comments
	public function action_view($id=0){}

	// View issues by tag name (open/unread/closed)
	public function action_tag($tag=NULL){}

	// Search issues
	public function action_search($keyword=NULL){}

	// Create issue
	public function action_create(){}

	// Edit issue
	public function action_edit($id=0){}

	// Delete issue
	public function action_delete($id=0){}

	// Comment on issue
	public function action_comment($id=0){}

	// Delete issue comment
	public function action_decomment($id=0){}

	// Edit issue comment
	public function action_recomment($id=0){}

}
