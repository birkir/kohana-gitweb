			<h1>{$project->title}</h1>
			<div id="project">
				<p>{$project->description}</p>
				<p><a href="{$project->website}">{$project->website}</a></p>
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
					<li><strong>commit</strong> <a href="{$path}{$project->alias}/commit/view/{$commit.h}">{$commit.h|substr:0:20}</a></li>
					<li><strong>tree</strong> <a href="{$path}{$project->alias}/tree/view/{$commit.tree}">{$commit.tree|substr:0:20}</a></li>
{if isset($commit.parents)}
					<li>
						<strong>parents</strong>
{foreach from=$commit.parents item=item}
						<a href="{$path}{$project->alias}/commit/view/{$item}">{$item|substr:0:20}</a><br />
{/foreach}
					</li>
{/if}
				</ul>
				<div class="clearfix"></div>
			</div>
			<div id="files">
				<table>
					<tbody>
{foreach from=$diff item=item}
						<tr>
							<td>icon.{$item.type}.png</td>
							<td>{$item.name}</td>
							<td>{$item.created+$item.deleted}</td>
						</tr>
{/foreach}
					</tbody>
				</table>
			</div>
			<div id="diff">
{foreach from=$diff item=item}
				<h2>{$item.name}</h2>
				<pre class="brush: {$item.mime}">
{foreach from=$item.diff item=line}
{$line}
{/foreach}
				</pre>
{/foreach}
			</div>