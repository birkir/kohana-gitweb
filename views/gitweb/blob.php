<ul class="breadcrumb">
        <?php $b = $tree->getBreadcrumb(); ?>
        <li<?=(count($b) === 0 ? ' class="active"' : NULL);?>><?=HTML::anchor(URL::site('gitweb/tree/'.$reference), $reponame);?></li>
        <?php foreach ($b as $i => $item): ?>
                <li<?=($i+1 === count($b) ? ' class="active"' : NULL);?>><?=HTML::anchor(URL::site('gitweb/tree/'.$reference.'/'.$item['path']), $item['label']);?></li>
        <?php endforeach; ?>
</ul>

<?php $m = $tree->getBlob(); ?>
<?php $content = $repository->outputRawContent($m, $reference); ?>

<div class="navbar navbar-toolbar">
	<ul class="nav">
		<a class="navbar-brand" href="#"><?=$m->getName();?></a>
		<p class="navbar-text pull-left">file</p>
		<p class="divider pull-left" style="color:#ccc;">|</p>
		<p class="navbar-text pull-left"><?=substr_count($content, "\n") + 1;?> lines</p>
		<p class="divider pull-left" style="color:#ccc;">|</p>
		<p class="navbar-text pull-left"><?=Text::bytes($m->getSize());?></p>
	</ul>
	<div class="btn-toolbar pull-right">
		<div class="btn-group">
			<a href="#" class="btn btn-default btn-small">Edit</a>
			<a href="#" class="btn btn-default">Raw</a>
			<a href="#" class="btn btn-default">Blame</a>
			<a href="#" class="btn btn-default">History</a>
		</div>
	</div>
</div>

<br>

<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
<div class="panel">
	<pre class="prettyprint linenums"><?=htmlentities($content);?></pre>
</div>
