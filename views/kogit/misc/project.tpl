{if isset($project)}
			<h1>{$project.title}</h1>
			<div id="project">
				<p>{$project.description}</p>
				<p><a href="{$project.website}">{$project.website}</a></p>
			</div>
{/if}