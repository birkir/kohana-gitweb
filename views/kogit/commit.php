<?php echo $project_info; ?>
<?php echo $commit; ?>
			<div id='files'>
				<table>
					<tbody>
<?php foreach ($diff as $key => $item): ?>
						<tr>
							<td style='width:10px;padding-right:0;'><img src='<?php echo $path; ?>media/img/icon.<?php echo $item['type']; ?>.png' alt='' /></td>
							<td style='padding-left:7px;'><a href='#diff-<?php echo $key; ?>'><?php echo $item['name']; ?></a></td>
							<td><?php echo ($item['created'] + $item['deleted']); ?></td>
						</tr>
<?php endforeach ?>
					</tbody>
				</table>
			</div>
			<div id='diff'>
<?php foreach ($diff as $key => $item): ?>
				<h2><a name='diff-<?php echo $key; ?>'><?php echo $item['name']; ?></a></h2>
				<div class='overflow-code'>
				<table class='code'>
					<tbody>
<?php foreach ($item['diff'] as $diff): ?>
						<tr>
							<td style='width:10px;'><?php if ($diff['type'] != '+'): echo $diff['lnr']; endif ?></td>
							<td style='width:10px;'><?php if ($diff['type'] != '-'): echo $diff['rnr']; endif ?></td>
							<th class='<?php if ($diff['type'] == '@'): echo 'diff'; elseif ($diff['type'] == '+'): echo 'plus'; elseif ($diff['type'] == '-'): echo 'minus'; endif ?>'><pre><?php echo $diff['line']; ?></pre></th>
						</tr>
<?php endforeach ?>
					</tbody>
				</table>
				</div>
				<div class='clearfix'></div>
<?php endforeach ?>
			</div>
