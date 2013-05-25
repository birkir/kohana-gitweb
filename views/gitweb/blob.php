<ul class="breadcrumb">
        <?php $b = $tree->getBreadcrumb(); ?>
        <li<?=(count($b) === 0 ? ' class="active"' : NULL);?>><?=HTML::anchor(URL::site('gitweb/tree/'.$reference), $reponame);?></li>
        <?php foreach ($b as $i => $item): ?>
                <li<?=($i+1 === count($b) ? ' class="active"' : NULL);?>><?=HTML::anchor(URL::site('gitweb/tree/'.$reference.'/'.$item['path']), $item['label']);?></li>
        <?php endforeach; ?>
</ul>

<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>

<div class="panel gitweb-blob-panel">
	<div class="panel-heading clearfix">
		<span class="pull-left text-muted">
			<?=$blob->getName();?>
			<span class="divider">|</span> file
			<span class="divider">|</span> <?=substr_count($content, "\n");?> <?=__('lines');?>
			<span class="divider">|</span> <?=Text::bytes($blob->getSize());?>
		</span>
		<div class="btn-toolbar pull-right">
			<div class="btn-group">
				<a href="<?=URL::site('gitweb/edit/'.$reference.'/'.$path);?>" class="btn btn-default btn-small">Edit</a>
				<a href="<?=URL::site('gitweb/raw/'.$reference.'/'.$path);?>" class="btn btn-default btn-small">Raw</a>
				<a href="<?=URL::site('gitweb/blame/'.$reference.'/'.$path);?>" class="btn btn-default btn-small">Blame</a>
				<a href="<?=URL::site('gitweb/commits/'.$reference.'/'.$path);?>" class="btn btn-default btn-small">History</a>
			</div>
		</div>
	</div>

	<pre class="prettyprint linenums"><?=htmlentities($content);?></pre>
</div>
