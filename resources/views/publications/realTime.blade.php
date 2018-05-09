<meta name="csrf-token" content="{{ csrf_token() }}">

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
            <ul>
                <li class="list-group-item">
                    <div class="row title">
                        <div class="col-xs-1">Count</div>
                        <div class="col-xs-11">Headline, name and author</div>
                    </div>
                </li>
            </ul>
            <ol class="custom-counter">

                @if (array_key_exists('errors', $resultsRealtime)) 
                    <h2>Errror: {{ $resultsRealtime['error'] }} </h2>
                @else
                    
                @end
            </ol>
        </div>
	</div>

	<div class="col-sm-6">
		<h3>Top 20 for day:</h3>
		<div id="curDayStories">
            <ul>
                <li class="list-group-item">
                    <div class="row title">
                        <div class="col-xs-1">Count</div>
                        <div class="col-xs-11">Headline, name and author</div>
                    </div>
                </li>
            </ul>
            
        </div>
	</div>
</div>