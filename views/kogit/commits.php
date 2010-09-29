			<h1><a href='<?php echo $path; ?>tree'><?php echo $project['title']; ?></a> / <?php echo __('Commit History'); ?></h1>
<?php $date = '0000-00-00'; ?>
			<div class='clearfix'></div>
			<div id='commits'>
<?php foreach ($commits as $commit): ?>
<?php if ($date != date('Y-m-d', $commit['committer_utcstamp'])): ?>
<?php $date = date('Y-m-d', $commit['committer_utcstamp']); ?>
				<br />
				<h3><?php echo $date; ?></h3>
<?php endif ?>
				<div class='commit'>
					<div class='details'>
						<p><?php echo $commit['message_full']; ?></p>
						<div class='author'>
							<strong><?php echo $commit['committer_name']; ?></strong><br />
							<span class='datetime'><?php echo date('Y-m-d H:i:s', $commit['committer_utcstamp']); ?></span>
						</div>
					</div>
					<ul>
						<li><strong><?php echo __('commit'); ?></strong> <a href='<?php echo $path; ?>commit/index/<?php echo $commit['h']; ?>'><?php echo substr($commit['h'], 0, 20); ?></a></li>
						<li><strong><?php echo __('tree'); ?></strong> <a href='<?php echo $path; ?>tree/index/<?php echo $commit['tree']; ?>'><?php echo substr($commit['tree'], 0, 20); ?></a></li>
<?php if (isset($commit['parents'])): ?>
						<li>
							<strong><?php echo __('parents'); ?></strong>
<?php foreach ($commit['parents'] as $item): ?>
							<a href='<?php echo $path; ?>commit/index/<?php echo $item; ?>'><?php echo substr($item, 0, 20); ?></a><br />
<?php endforeach ?>
						</li>
<?php endif ?>
					</ul>
					<div class='clearfix'></div>
				</div>
<?php endforeach ?>
			</div>
<?php echo $pagination; ?>
			<div class='clearfix'></div>
