<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
		<title>KoGit 1.0</title>
		<link href="{$path}kogit/media/css/kogit.css" type="text/css" rel="stylesheet" media="screen" charset="utf-8" />
		<link href="{$path}kogit/media/css/syntaxhighlighter.css" type="text/css" rel="stylesheet" />
		<script src="{$path}kogit/media/js/syntaxhighlighter.js" type="text/javascript"></script>
		<script src="{$path}kogit/media/js/kogit.js" type="text/javascript"></script>
	</head>
	<body>
		<div id="wrap">
			<div id="header">
				<div id="logo">Ko-Git v1.0</div>
				<div id="user">birkir.gudjonsson@gmail.com</div>
				<div class="clearfix"></div>
			</div>
			<div id="controllers">
				<ul>
					<li><a href="{$path}{$project->alias}/tree/head" {if $controller == "tree" OR $controller == "blob"} class="current"{/if}>Source</a></li>
					<li><a href="{$path}{$project->alias}/commits" {if $controller == "commits"} class="current"{/if}>Commits</a></li>
					<li><a href="{$path}{$project->alias}/issues" {if $controller == "issues"} class="current"{/if}>Issues</a></li>
					<li><a href="{$path}{$project->alias}/downloads" {if $controller == "downloads"} class="current"{/if}>Downloads</a></li>
					<li><a href="{$path}{$project->alias}/wiki" {if $controller == "wiki"} class="current"{/if}>Wiki</a></li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<h1>{$project->title}</h1>
{if isset($view)}{$view}{/if}
		</div>
	</body>
</html>
