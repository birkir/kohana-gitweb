			<h1>{$project->title}</h1>
			<div id="project">
				<p>{$project->description}</p>
				<p><a href="{$project->website}">{$project->website}</a></p>
			</div>
{if isset($commit.committer_name)}
			<div id="commit">
				<div class="details">
					<p>{$commit.message_full}</p>
					<div class="author">
						<strong>{$commit.committer_name}</strong><br />
						<span class="datetime">{'Y-m-d H:i:s'|date:$commit.committer_utcstamp}</span>
					</div>
				</div>
				<ul>
					<li><strong>commit</strong> <a href="{$path}{$project->alias}/commit/view/{$commit.h}">{$commit.h|substr:0:20}</a></li>
					<li><strong>tree</strong> <a href="{$path}{$project->alias}/tree/view/{$commit.tree}">{$commit.tree|substr:0:20}</a></li>
					<li>
						<strong>parents</strong>
{foreach from=$commit.parents item=item}
						<a href="{$path}{$project->alias}/commit/{$item}">{$item|substr:0:20}</a><br />
{/foreach}
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
{/if}
{if isset($blob)}
			<div id="blob">
				<pre class="brush: css">
{$blob}
				</pre>
			</div>
{/if}
