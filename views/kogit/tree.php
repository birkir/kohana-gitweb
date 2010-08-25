<?php echo $project_info; ?>
<?php echo $commit; ?>
			<div id="tree">
				<table cellspacing="0">
					<thead>
						<tr>
							<th style="padding:0;"></th>
							<th style="padding-left:0;"><?php echo __("name"); ?></th>
							<th><?php echo __("age"); ?></th>
							<th><?php echo __("message"); ?></th>
							<th style="text-align:right;"><a href="<?php echo $path; ?>/commit/" style="color:#fff;"><?php echo __("history"); ?></a></th>
						</tr>
					</thead>
					<tbody>
<?php foreach ($tree as $item): ?>
						<tr>
							<td style="padding:7px;"><img src="<?php echo $path; ?>media/img/icon.<?php echo $item['type']; ?>.png" alt="" /></td>
							<td style="padding-left:0;"><a href="<?php echo $path; ?><?php echo $item['type']; ?>/index/<?php echo $hash; ?>/<?php echo $item['name']; ?>"><?php echo $item['file']; ?></a></td>
							<td><?php if (isset($item['info']['committer_utcstamp'])): ?><?php echo __(Date::fuzzy_span($item['info']['committer_utcstamp'])); else: echo __('Unknown'); endif ?></td>
							<td colspan="2" style="width:65%;"><?php if (isset($item['info']['message'])): ?><?php echo Text::limit_chars($item['info']['message'], 50).' ['.$item['info']['committer_name'].']'; else: echo __('Unknown'); endif ?></td>
						</tr>
<?php endforeach ?>
					</tbody>
				</table>
			</div>
<?php if (isset($readme_md) OR isset($readme)): ?>
			<br />
			<h2><?php echo __('Readme'); ?></h2>
			<div id="readme">
<?php if (isset($readme)): ?>
				<pre style="padding:0 0 0 4px;">
<?php echo $readme; ?>
				</pre>
<?php else: ?>
				<div class="markdown">
					<hr />
<?php echo $readme_md; ?>
				</div>
<?php endif ?>
			</div>
<?php endif ?>
