<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>KoGit 1.0</title>
		<link href="<?php echo $path; ?>media/css/kogit.css" type="text/css" rel="stylesheet" media="screen" charset="utf-8" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
		<script src="<?php echo $path; ?>media/js/kogit.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="wrap">
			<div id="header">
				<div id="logo">KoGit</div>
				<div class="clearfix"></div>
			</div>
			<div id="controllers">
				<ul>
					<li><a href="<?php echo $path; ?>tree"<?php if($controller == "tree" OR $controller == "blob"): echo ' class="current"'; endif ?>><?php echo __('Source'); ?></a></li>
					<li><a href="<?php echo $path; ?>commits"<?php if($controller == "commits" OR $controller == "commit"): echo ' class="current"'; endif ?>><?php echo __('Commits'); ?></a></li>
					<li><a href="<?php echo $path; ?>issues"<?php if($controller == "issues"): echo ' class="current"'; endif ?>><?php echo __('Issues'); ?></a></li>
					<li><a href="<?php echo $path; ?>downloads"<?php if($controller == "downloads"): echo ' class="current"'; endif ?>><?php echo __('Downloads'); ?></a></li>
					<li><a href="<?php echo $path; ?>wiki"<?php if($controller == "wiki"): echo ' class="current"'; endif ?>><?php echo __('Wiki'); ?></a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
<?php if (isset($view)): ?>
<?php echo $view; ?>
<?php endif ?>
		</div>
	</body>
</html>
