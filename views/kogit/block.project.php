<?php if (isset($project)): ?>
			<h1><?php echo $project['title']; ?></h1>
			<div id="project">
				<p><?php echo $project['description']; ?></p>
				<p><a href="<?php echo $project['website']; ?>"><?php echo $project['website']; ?></a></p>
			</div>
<?php endif ?>
