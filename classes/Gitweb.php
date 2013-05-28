<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Helper class for Gitweb processing
 */
class Gitweb {

	public static function diff_stats(GitElephant\Objects\Diff\Diff $diff)
	{
		// Initialize statistics array
		$stats = array(
			'index'    => 0,
			'mode'     => 0,
			'new_file' => 0,
			'deleted'  => 0,
			'deleted_file' => 0,
			'line-added' => 0,
			'line-deleted' => 0,
			'line-unchanged' => 0
		);

		// Loop through diff
		foreach ($diff as $diffObject)
		{
			// Iterate index, mode, new_file and deleted states.
			$stats[$diffObject->getMode()]++;

			// Loop through chucnks
			foreach ($diffObject as $diffChunk)
			{
				// Loop through lines in chunk
				foreach ($diffChunk as $diffLine)
				{
					// Iterate lines added and deleted
					$stats['line-'.$diffLine->getType()]++;
				}
			}
		}

		return $stats;
	}

}