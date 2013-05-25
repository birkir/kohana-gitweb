<br>

<div class="alert alert-info">
	<strong><?=$commit->getMessage();?></strong>
	<br>
	<span class="text-muted"><?=$commit->getAuthor()->getName();?> authored <?=Date::fuzzy_span($commit->getDatetimeAuthor()->getTimestamp());?></span>
	<a href="<?=URL::site('gitweb/tree/'.$commit->getSha());?>" class="pull-right text-muted">latest commit</span> <span style="color:#333;"><?=$commit->getSha(TRUE);?></span></a>
</div>

<p><?=__('Showing <strong>:num changed files</strong> with <strong>:additions additions</strong> and <strong>:deletions deletions</strong>.', array(
	':num' => ($stats['mode'] + $stats['index'] + $stats['new_file'] + $stats['deleted']),
	':additions' => $stats['line-added'],
	':deletions' => $stats['line-deleted']
)); ?></p>

<?php foreach ($diff as $file): ?>
	<div class="panel">
		<div class="panel-heading">
			<?=$file;?><?php if ($file->count() === 0): ?> (deleted)<?php endif; ?>
		</div>
		<div class="panel-body" style="margin: -15px;">
			<table class="table table-hover gitweb-diff-table">
				<tbody>
			<?php foreach ($file as $lines): ?>
					<tr class="headerline">
						<td>...</td>
						<td>...</td>
						<td><?=$lines->getHeaderLine();?></td>
					</tr>
				<?php foreach ($lines as $l => $line): ?>
					<tr class="<?=$rowClass[$line->getType()];?>">
						<td><?=$line->getOriginNumber();?></td>
						<td><?=$line->getDestNumber();?></td>
						<td><pre><?=htmlentities($line);?></pre></td>
					</tr>
				<?php endforeach; ?>
			<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
<?php endforeach; ?>
