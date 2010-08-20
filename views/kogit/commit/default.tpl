{$project}
{$commit}
			<div id="files">
				<table>
					<tbody>
{foreach from=$diff key=key item=item}
						<tr>
							<td style="width:10px;padding-right:0;"><img src="{$path}media/img/icon.{$item.type}.png" alt="" /></td>
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