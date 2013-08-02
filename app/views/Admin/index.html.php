<h1>Admin main screen</h1>

<div class="well span12">
	<div class="well span6">
		<h2>Most commits</h2>
		<ol>
		<?php 
		foreach($this->commits as $pdata) { ?>
			<li><?=$pdata['project']->name?> - <?=$pdata['commits']?> commits 
				(<a href="http://www.lookingforpullrequests.com/project/<?=$pdata['project']->id?>" target="_blank">open</a>)
			</li>
		<?php } ?>
		</ol>
	</div>

	<div class="well span6">
		<h2>Most pull requests</h2>
		<ol>
		<?php 
		foreach($this->most_pr as $pdata) { ?>
			<li><?=$pdata['project']->name?> - <?=$pdata['total_activity']?> 
					pulls (<?=$pdata['new_pulls']?> + <?=$pdata['closed_pulls']?> + <?=$pdata['merged_pulls']?>)

				(<a href="http://www.lookingforpullrequests.com/project/<?=$pdata['project']->id?>" target="_blank">open</a>)
				</li>
		<?php } ?>
		</ol>
	</div>
	<div class="well span6">
		<h2>Latest projects</h2>
		<ol>
		<?php 
		foreach($this->latest as $pdata) { ?>
			<li><?=$pdata->name?> (Id: <?=$pdata->id?>)
				(<a href="http://www.lookingforpullrequests.com/project/<?=$pdata->id?>" target="_blank">open</a>)
			</li>
		<?php } ?>
		</ol>
	</div>
	<div class="well span6">
		<h2>Suscribers</h2>
		<ol>
		<?php 
		foreach($this->suscribers as $sus) { ?>
			<li><?=$sus->email?> (Id: <?=$sus->id?>)</li>
		<?php } ?>
		</ol>
	</div>
</div>