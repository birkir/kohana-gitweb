<h3><?=__('Tags');?></h3>

<table class="table">
	<tbody>
		<?php foreach ($tags as $tag): $commit = $repository->getLog($tag, NULL, 1, 0)->first(); ?>
			<tr>
				<td width="200" class="text-muted"><?=Gitweb::date($commit->getDatetimeAuthor());?></td>
				<td>
					<strong><?=$tag->getName();?></strong><br>
					<ul class="list-inline">
						<li><a href="#"><i class="icon-arrow-right"></i> <?=substr($tag->getSha(), 0, 7);?></a></li>
						<li><a href="#"><i class="icon-download-alt"></i> zip</a></li>
						<li><a href="#"><i class="icon-download-alt"></i> tar.gz</a></li>
					</ul>
				</td>
			</tr>
		<?php endforeach; ?>
	</tbody>
</table>
