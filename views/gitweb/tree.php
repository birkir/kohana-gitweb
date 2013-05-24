<ul class="breadcrumb">
	<?php $b = $tree->getBreadcrumb(); ?>
	<li<?=(count($b) === 0 ? ' class="active"' : NULL);?>><?=HTML::anchor(URL::site('gitweb/tree/'.$reference), $reponame);?></li>
	<?php foreach ($b as $i => $item): ?>
		<li<?=($i+1 === count($b) ? ' class="active"' : NULL);?>><?=HTML::anchor(URL::site('gitweb/tree/'.$reference.'/'.$item['path']), $item['label']);?></li>
	<?php endforeach; ?>
</ul>

<table class="table table-hover table-striped gitweb-tree-table">
	<thead>
		<tr>
			<td colspan="3" class="commit-message">
				<a href="#"><?=$commit->getMessage();?></a>
			</td>
		</tr>
		<tr>
			<td colspan="3" class="commit-author">
				<strong><?=$commit->getAuthor()->getName();?></strong>
				<span class="text-muted"> authored <?=Date::fuzzy_span($commit->getDatetimeAuthor()->getTimestamp());?></span>
				<a href="#" class="pull-right text-muted">latest commit</span> <span style="color:#333;"><?=UTF8::substr($commit->getSha(), 0 , 10);?></span></a>
			</td>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($files as $file): ?>
			<tr>
				<td>
					<i class="icon-<?=($file['type'] === 'tree' ? 'folder-close' : 'file-alt');?>"></i>
					<?=HTML::anchor($file['uri'], $file['name'], array('class' => 'path'));?>
				</td>
				<td><?=Date::fuzzy_span($file['commit']->getDatetimeAuthor()->getTimestamp());?></td>
				<td><?=$file['commit']->getMessage();?> [<a href="#"><?=$file['commit']->getAuthor()->getName();?></a>]</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>

<?php if ( ! empty($readme)): ?>
<div class="panel">
	<div class="panel-heading"><span class="icon-book"></span> Readme</div>
	<?=$readme;?>
</div>
<?php endif; ?>
