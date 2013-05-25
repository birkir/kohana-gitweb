<h3><?=__('Branches');?></h3>

<p><?=__('Showing :num branches not merged into :ref.', array(
	':num' => count($branches),
	':ref' => $reference
));?> <a href="#"><?=__('View merged branches');?></a>.</p>

<div class="list-group gitweb-branches-list">
	<?php foreach ($branches as $branch): $commit = $repository->getLog($branch, NULL, 1, 0)->first(); ?>
		<div class="list-group-item<?=$branch->getName() === $reference ? ' active' : NULL;?>">
			<?php if ($branch->getName() === $reference): ?>
				<small class="pull-right"><strong>Base branch</strong></small>
			<?php else: ?>
				<a href="<?=URL::site('gitweb/compare/'.$reference.'...'.$branch->getName());?>" class="btn btn-default btn-small pull-right">
					<i class="icon-copy"></i> <?=__('Compare');?>
				</a>
			<?php endif; ?>
			<a href="<?=URL::site('gitweb/tree/'.$branch->getName());?>" class="name">
				<?=$branch->getName();?>
			</a>
			<br>
			<span>
				<?=__('Last updated :fuzzyspan by ', array(
					':fuzzyspan' => Date::fuzzy_span($commit->getDatetimeAuthor()->getTimestamp())
				));?>
				<a href="#"><?=$commit->getAuthor()->getName();?></a>
			</span>
		</div>
	<?php endforeach; ?>
</div>