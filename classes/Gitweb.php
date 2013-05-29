<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Helper class for Gitweb processing
 *
 * @category Gitweb
 * @author Birkir Gudjonsson (birkir.gudjonsson@gmail.com)
 * @licence Kohana Licence
 */
class Gitweb {

	/**
	 * Facebook style time parser
	 *
	 * @param DateTime time
	 * @return string
	 */
	public static function date(DateTime $date)
	{
		// units and span array
		$units = array('second', 'minute', 'hour', 'day', 'month', 'year', 'decade');
		$span = array(60, 60, 24, 30.4375, 12, 10);

		// dates to unix timestamp
		$now = time();
		$to = $date->getTimestamp();

		// calculate difference
		$diff = $now > $to ? $now - $to : $to - $now;

		// divide diff to span
		for ($i = 0; $diff >= $span[$i] && $i < (count($span)-1); $i++) $diff /= $span[$i];

		return round($diff).' '.$units[$i].($diff > 1 ? 's' : NULL).' '.($now > $to ? 'ago' : 'from now');
	}

	/**
	 * Stats for Diff Object
	 *
	 * @return array
	 */
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
