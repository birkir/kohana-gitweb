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
					<li><strong>commit</strong> <a href="{$path}commit/index/{$commit.h}">{$commit.h|substr:0:20}</a></li>
					<li><strong>tree</strong> <a href="{$path}tree/index/{$commit.tree}">{$commit.tree|substr:0:20}</a></li>
					<li>
						<strong>parents</strong>
{foreach from=$commit.parents item=item}
						<a href="{$path}commit/{$item}">{$item|substr:0:20}</a><br />
{/foreach}
					</li>
				</ul>
				<div class="clearfix"></div>
			</div>
{/if}