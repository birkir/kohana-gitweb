<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>KoGit 1.0</title>
		<link href="{$path}media/css/kogit.css" type="text/css" rel="stylesheet" media="screen" charset="utf-8" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
		<script src="{$path}media/js/kogit.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="wrap">
			<div id="header">
				<div id="logo">KoGit</div>
				<div class="clearfix"></div>
			</div>
			<div id="controllers">
				<ul>
					<li><a href="{$path}tree" {if $controller == "tree" OR $controller == "blob"} class="current"{/if}>Source</a></li>
					<li><a href="{$path}commits" {if $controller == "commits" OR $controller == "commit"} class="current"{/if}>Commits</a></li>
					<li><a href="{$path}issues" {if $controller == "issues"} class="current"{/if}>Issues</a></li>
					<li><a href="{$path}downloads" {if $controller == "downloads"} class="current"{/if}>Downloads</a></li>
					<li><a href="{$path}wiki" {if $controller == "wiki"} class="current"{/if}>Wiki</a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
{if isset($view)}{$view}{/if}
		</div>
	</body>
</html>
