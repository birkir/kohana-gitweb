<ul class="breadcrumb">
	<li><a href="<?=URL::site('gitweb');?>"><strong><?=$reponame;?></strong></a></li>
	<li class="active"><?=__('Commit History');?></li>
</ul>

<div class="panel">
	<div class="panel-heading panel-heading-condensed">
		<?php $date = $commits->first()->getDatetimeAuthor()->format('Ymd'); ?>
		<?=$commits->first()->getDatetimeAuthor()->format('d. M Y');?>
	</div>
	<div class="list-group list-group-flush gitweb-commits-list">
		<?php foreach ($commits as $commit): ?>
			<?php if ($commit->getDatetimeAuthor()->format('Ymd') !== $date): ?>
				<?php $date = $commit->getDatetimeAuthor()->format('Ymd'); ?>
				</div></div><div class="panel"><div class="panel-heading panel-heading-condensed">
				<?=$commit->getDatetimeAuthor()->format('d. M Y');?>
				</div><div class="list-group list-group-flush gitweb-commits-list">
			<?php endif; ?>
			<a href="<?=URL::site('gitweb/commit/'.$commit->getSha());?>" class="list-group-item">
				<strong><?=$commit->getMessage();?></strong><br>
				<?=$commit->getAuthor()->getName();?>
				<span class="text-muted"><?=__('authored');?> <?=Date::fuzzy_span($commit->getDatetimeAuthor()->getTimestamp());?></span>
			</a>
		<?php endforeach; ?>
	</div>
</div>

<ul class="pager">
	<?php if ($page === 1): ?>
		<li class="disabled"><span><?=__('Newer');?></span></li>
	<?php else: ?>
		<li><a href="<?=URL::site(Request::current()->uri());?>?page=<?=$page-1;?>"><?=__('Newer');?></a></li>
	<?php endif; ?>
	<?php if ($commits->count() == $limit): ?>
		<li><a href="<?=URL::site(Request::current()->uri());?>?page=<?=$page+1;?>"><?=__('Older');?></a></li>
	<?php else: ?>
		<li class="disabled"><span><?=__('Older');?></span></li>
	<?php endif; ?>
</ul>
