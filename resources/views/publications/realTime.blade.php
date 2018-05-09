<div class="row">
	<ul>
		<li class='list-group-item'>
			<span class='realTimeTotalReport totalsReport'>
				Currently On Bendbulletin: <span id='totalCurrentCount'></span>
			</span>
		</li>
	</ul>

	<div class="col-sm-6">
		<h3>Top 20 stories right now:</h3>
		<div id="realTimeStories">
       
        </div>
	</div>

	<div class="col-sm-6">
		<h3>Top 20 for day:</h3>
		<div id="curDayStories">
            {{ var_dump($results) }}
        </div>
	</div>
</div>