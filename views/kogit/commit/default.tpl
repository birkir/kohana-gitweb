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
{foreach from=$diff key=key item=item}
						<tr>
							<td style="width:10px;padding-right:0;"><img src="{$path}kogit/media/img/icon.{$item.type}.png" alt="" /></td>
							<td style="padding-left:7px;"><a href="#diff-{$key}">{$item.name}</a></td>
							<td>{$item.created+$item.deleted}</td>
						</tr>
{/foreach}
					</tbody>
				</table>
			</div>
			<div id="diff">
{foreach from=$diff key=key item=item}
				<h2><a name="diff-{$key}">{$item.name}</a></h2>
				<div class="overflow-code">
				<table class="code">
					<tbody>
{foreach from=$item.diff item=diff}
						<tr>
							<td>{if $diff.type != '+'}{$diff.lnr}{/if}</td>
							<td>{if $diff.type != '-'}{$diff.rnr}{/if}</td>
							<th class="{if $diff.type == '@'}diff{elseif $diff.type == '+'}plus{elseif $diff.type == '-'}minus{/if}"><pre>{$diff.line}</pre></th>
						</tr>
{/foreach}
					</tbody>
				</table>
				</div>
				<div class="clearfix"></div>
{/foreach}
			</div>