<div id="repository-details">
	{$project->description}
	{$project->website}
</div>
<div id="commit">
	<div class="details">
		<p>{$commit.message_full}</p>
		<div class="author">
			<strong>{$commit.committer_name}</strong><br />
			<span class="datetime">{'Y-m-d H:i:s'|date:$commit.committer_utcstamp}</span>
		</div>
	</div>
	<ul>
		<li><strong>commit</strong> <a href="{$path}{$project->alias}/commit/{$commit.h}">{$commit.h|substr:0:20}</a></li>
		<li><strong>tree</strong> <a href="{$path}{$project->alias}/tree/{$commit.tree}">{$commit.tree|substr:0:20}</a></li>
		<li>
			<strong>parents</strong>
{foreach from=$commit.parents item=item}
			<a href="{$path}{$project->alias}/commit/{$item}">{$item|substr:0:20}</a>
{/foreach}
		</li>
	</ul>
</div>
<div id="blob">
<pre>{$blob}</pre>
</div>