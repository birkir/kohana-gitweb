<br>

<p>Showing <strong><?=($stats['mode'] + $stats['index'] + $stats['new_file'] + $stats['deleted']);?> changed files</strong> with <strong><?=$stats['line-added'];?> additions</strong> and <strong><?=$stats['line-deleted'];?> deletions</strong>.</p>

<?php foreach ($diff as $file): ?>
	<div class="panel">
		<div class="panel-heading"><?=$file;?></div>
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
