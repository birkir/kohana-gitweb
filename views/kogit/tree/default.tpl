{$project}
{$commit}
			<div id="tree">
				<table cellspacing="0">
					<thead>
						<tr>
							<th style="padding:0;"></th>
							<th style="padding-left:0;">name</th>
							<th>age</th>
							<th>message</th>
							<th style="text-align:right;"><a href="{$path}/commit/" style="color:#fff;">history</a></th>
						</tr>
					</thead>
					<tbody>
{foreach from=$tree item=item}
						<tr>
							<td style="padding:7px;"><img src="{$path}media/img/icon.{$item.type}.png" alt="" /></td>
							<td style="padding-left:0;"><a href="{$path}{$item.type}/index/{$hash}/{$item.name}">{$item.file}</a></td>
							<td>{if isset($item.info.committer_utcstamp)}{'Y-m-d H:i:s'|date:$item.info.committer_utcstamp}{else}0000-00-00 00:00:00{/if}</td>
							<td colspan="2">{if isset($item.info.message)}{$item.info.message|truncate:50} [{$item.info.committer_name}]{else}Unknown{/if}</td>
						</tr>
{/foreach}
					</tbody>
				</table>
			</div>
{if isset($readme_md) OR isset($readme)}
			<br />
			<h2>Readme</h2>
			<div id="readme">
{if isset($readme)}
				<pre style="padding:0 0 0 4px;">
{$readme}
				</pre>
{else}
				<div class="markdown">
					<hr />
{$readme_md}
				</div>
{/if}
			</div>
{/if}