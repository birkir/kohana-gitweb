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
					<li><strong>commit</strong> <a href="{$path}{$project->alias}/commit/{$commit.h}">{$commit.h|substr:0:20}</a></li>
					<li><strong>tree</strong> <a href="{$path}{$project->alias}/tree/{$commit.tree}">{$commit.tree|substr:0:20}</a></li>
					<li>
						<strong>parents</strong>
{foreach from=$commit.parents item=item}
						<a href="{$path}{$project->alias}/commit/{$item}">{$item|substr:0:20}</a><br />
{/foreach}
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
			<div id="tree">
				<table cellspacing="0">
					<thead>
						<tr>
							<th style="padding:0;"></th>
							<th style="padding-left:0;">name</th>
							<th>age</th>
							<th>message</th>
							<th style="text-align:right;"><a href="{$path}{$project->alias}/commits/head" style="color:#fff;">history</a></th>
						</tr>
					</thead>
					<tbody>
{foreach from=$tree item=item}
						<tr>
							<td style="padding:7px;"><img src="{$path}kogit/media/img/icon.{$item.type}.png" alt="" /></td>
							<td style="padding-left:0;"><a href="{$path}{$project->alias}/{$item.type}/head/{$item.name}">{$item.file}</a></td>
							<td>{if isset($item.info.committer_utcstamp)}{'Y-m-d H:i:s'|date:$item.info.committer_utcstamp}{else}0000-00-00 00:00:00{/if}</td>
							<td colspan="2">{if isset($item.info.message)}{$item.info.message|truncate:50} [{$item.info.committer_name}]{else}Unknown{/if}</td>
						</tr>
{/foreach}
					</tbody>
				</table>
			</div>
{if $readme}
			<br />
			<div id="readme">
			<h2>Readme</h2>
			<pre>
{$readme}
			</pre>
			</div>
{/if}