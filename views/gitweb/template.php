<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Meta, title, CSS, favicons, etc. -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<title>Gitweb 3.3</title>

		<!-- Bootstrap core CSS -->
		<link href="/gitweb-media/css/bootstrap.css" rel="stylesheet">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
			<script src="/gitweb-media/js/html5shiv.js"></script>
			<script src="/gitweb-media/js/respond/respond.min.js"></script>
		<![endif]-->

		<!-- Favicons -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="/gitweb-media/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="/gitweb-media/ico/apple-touch-icon-114-precomposed.png">
		  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="/gitweb-media/ico/apple-touch-icon-72-precomposed.png">
		                <link rel="apple-touch-icon-precomposed" href="/gitweb-media/ico/apple-touch-icon-57-precomposed.png">
                                               <link rel="shortcut icon" href="/gitweb-media/ico/favicon.png">

		<link href="/gitweb-media/css/todc-bootstrap.css" rel="stylesheet"></head>
		<link href="/gitweb-media/css/select2.css" rel="stylesheet">
		<link href="/gitweb-media/css/application.css" rel="stylesheet">
	</head>
	<body>

		<div class="navbar navbar-static-top" style="margin-bottom:0;">
			<a class="navbar-brand" href="#">Gitweb</a>
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Code</a></li>
				<li><a href="#">Network</a></li>
				<li><a href="#">Pull Requests</a></li>
				<li><a href="#">Issues</a></li>
				<li><a href="#">Wiki</a></li>
				<li><a href="#">Graphs</a></li>
				<li><a href="#">Settings</a></li>
			</ul>
		</div>
<!--
		<div class="navbar navbar-masthead">
			<div class="container">
				<p class="navbar-text">Repository Browser</p>
			</div>
		</div>
-->
<br>

		<div class="container">
			<div class="btn-group gitweb-branch-menu pull-left">
				<button type="button" class="btn btn-default btn-small dropdown-toggle" data-toggle="dropdown">
					<span class="text-muted"><?=$reference_type;?>:</span>
					<strong><?=$reference instanceof GitElephant\Objects\Commit ? $reference->getSha(TRUE) : $reference;?></strong>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
					<?php foreach ($repository->getBranches() as $item): ?>
						<li>
							<a href="<?=URL::site('gitweb/'.$action.'/'.$item->getName());?>">
								<?php if ($item->getName() === $reference): ?>
									<strong><?=$item->getName();?></strong>
								<?php else: ?>
									<?=$item->getName();?>
								<?php endif; ?>
							</a>
						</li>
					<?php endforeach; ?>
				</ul>
			</div>

			<ul class="nav nav-tabs">
				<?php foreach ($menu as $item): ?>
					<li<?=HTML::attributes($item['attr']);?>><?=HTML::anchor($item['path'], $item['name']);?></li>
				<?php endforeach; ?>
			</ul>

			<?=(isset($view) ? $view: NULL);?>
		</div>

		<!-- JS and analytics only. -->
		<!-- Bootstrap core JavaScript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="/gitweb-media/js/jquery.js"></script>
		<script src="/gitweb-media/js/bootstrap.js"></script>
		<script src="/gitweb-media/js/select2.min.js"></script>
		<script src="/gitweb-media/js/application.js"></script>
	</body>
</html>
