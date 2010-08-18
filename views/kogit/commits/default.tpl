			<h1><a href="{$path}{$project->alias}">{$project->title}</a> / Commit History</h1>
{assign var='date' value='0000-00-00'}
			{$pagination}
			<div class="clearfix"></div>
			<div id="commits">
{foreach from=$commits item=commit}
{if $date != 'Y-m-d'|date:$commit.committer_utcstamp}
{assign var='date' value='Y-m-d'|date:$commit.committer_utcstamp}
				<h2>{$date}</h2>
{/if}
				<div class="commit">
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
{/foreach}
			</div>
			{$pagination}
			<div class="clearfix"></div>