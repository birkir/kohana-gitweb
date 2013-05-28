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
		<div class="navbar navbar-static-top">
			<a class="navbar-brand" href="<?=URL::site('gitweb');?>">Gitweb</a>
			<ul class="nav navbar-nav">
				<li class="active"><a href="#">Code</a></li>
				<li><a href="#">Network</a></li>
				<li><a href="#">Pull Requests</a></li>
				<li><a href="#">Issues</a></li>
				<li><a href="#">Wiki</a></li>
				<li><a href="#">Graphs</a></li>
			</ul>
		</div>
		<div class="container">
			<div class="navbar navbar-toolbar">
				<ul class="nav navbar-nav">
					<li class="dropdown">
						<a data-toggle="dropdown" class="navbar-brand dropdown-toggle" href="#">
							<?=$reference instanceof GitElephant\Objects\Commit ? '#'.$reference->getSha(TRUE) : $reference;?>
							<b class="caret"></b>
						</a>
						<ul class="navbar-brand dropdown-menu" role="menu" aria-labelledby="dropdownMenu">
							<?php foreach ($repository->getBranches() as $item): ?>
								<li>
									<a href="<?=URL::site('gitweb/'.$action.'/'.$item->getName());?>" tabindex="-1">
										<?php if ($item->getName() === $reference): ?>
											<strong><?=$item->getName();?></strong>
										<?php else: ?>
											<?=$item->getName();?>
										<?php endif; ?>
									</a>
								</li>
							<?php endforeach; ?>
						</ul>
					</li>
				</ul>
				<ul class="nav navbar-nav">
					<?php foreach ($menu as $name => $item): ?>
						<li<?=($item['active'] ? ' class="active"' : NULL);?>><?=HTML::anchor(URL::site('gitweb/'.$item['path']), __($name));?></li>
					<?php endforeach; ?>
				</ul>
			</div>
			<?=(isset($view) ? $view: NULL);?>
			<br>
			<footer>
				<hr>
				<a href="http://github.com/birkir/kohana-gitweb" target="_blank">Gitweb Repository Browser</a> for <a href="http://kohanaframework.org" target="_blank">Kohana 3.3.0</a>
				<a href="http://github.com/kohana/kohana/blob/3.3/master/LICENSE.md" class="pull-right" target="_blank">Kohana Licence</a>
				<br>
				<br>
			</footer>
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
