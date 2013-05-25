<br>
<div class="alert alert-info">
	<strong><?=$commit->getMessage();?></strong>
	<br>
	<span class="text-muted"><?=$commit->getAuthor()->getName();?> authored <?=Date::fuzzy_span($commit->getDatetimeAuthor()->getTimestamp());?></span>
	<a href="<?=URL::site('gitweb/tree/'.$commit->getSha());?>" class="pull-right text-muted">latest commit</span> <span style="color:#333;"><?=$commit->getSha(TRUE);?></span></a>
</div>

<ul class="breadcrumb">
	<?php $b = $tree->getBreadcrumb(); ?>
	<li<?=(count($b) === 0 ? ' class="active"' : NULL);?>><?=HTML::anchor(URL::site('gitweb/tree/'.$reference), $config['name']);?></li>
	<?php foreach ($b as $i => $item): ?>
		<li<?=($i+1 === count($b) ? ' class="active"' : NULL);?>><?=HTML::anchor(URL::site('gitweb/tree/'.$reference.'/'.$item['path']), $item['label']);?></li>
	<?php endforeach; ?>
</ul>

<table class="table table-hover gitweb-tree-table">
	<thead>
		<tr>
			<th width="150"><?=__('Filename');?></th>
			<th width="150"><?=__('Age');?></th>
			<th><?=__('Last commit');?></th>
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
