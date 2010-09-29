<?php if (isset($commit['committer_name'])): ?>
			<div id='commit'>
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
					<li>
						<strong><?php echo __('parents'); ?></strong>
<?php foreach ($commit['parents'] as $item): ?>
						<a href='<?php echo $path; ?>commit/<?php echo $item; ?>'><?php echo substr($item, 0, 20); ?></a><br />
<?php endforeach ?>
					</li>
				</ul>
				<div class='clearfix'></div>
			</div>
<?php endif ?>
