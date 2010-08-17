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
<div id="tree">
	<table cellspacing="0">
		<thead>
			<tr>
				<th>icon</th>
				<th>name</th>
				<th>age</th>
				<th>message</th>
			</tr>
		</thead>
		<tbody>
{foreach from=$tree item=item}
			<tr>
				<td>{$item.type}</td>
				<td><a href="{$path}{$project->alias}/{$item.type}/head/{$item.name}">{$item.file}</a></td>
				<td>{'Y-m-d H:i:s'|date:$item.info.committer_utcstamp}</td>
				<td>{$item.info.message} [{$item.info.committer_name}]</td>
			</tr>
{/foreach}
		</tbody>
	</table>
</div>