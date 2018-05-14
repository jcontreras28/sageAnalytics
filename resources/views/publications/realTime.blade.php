<meta name="csrf-token" content="{{ csrf_token() }}">

<div class="row">
	<ul>
		<li class='list-group-item'>
			<span class='realTimeTotalReport totalsReport'>
				Currently On Bendbulletin: <span id='totalCurrentCount'>{{ $resultsRealtime['allPageTotal'] }}</span>
			</span>
		</li>
	</ul>
</div>

<div class="row">
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
                    <h2>Errror: {{ $resultsRealtime['error'] }}
                @else
                    @foreach( $resultsRealtime['stories'] as $story)
                    <li class="list-group-item list-group-item-ordered">
                        <div class="row">
                            <div class="col-xs-1">
                                {{ $story['count'] }}
                            </div>
                            <div class="col-xs-11">
                                @if (array_key_exists('image', $story) && $story['image'] != 'none') 
                                    <img class='pull-right storyImage' width='80px' src='{{ $story["image"] }}'/ >
                                @endif
                                <span class='storyHeadlineBold'> {{ $story['headline'] }}</span><br>
                                <span>{{ $story['name'] }}</span><br>
                                <a href='{{ $story["link"] }}' target='_blank'>View story</a>
                            </div>
                        </div>
                    </li>
                    @endforeach
                @endif
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
            <ol class="custom-counter">

                @if (array_key_exists('errors', $results)) 
                    <h2>Errror: {{ $results['error'] }}
                @else

                    @foreach($results["articles"] as $key => $story )
                        @if ($loop->index > 20) 
                            @break
                        @endif
                        <li class="list-group-item list-group-item-ordered">
                            <div class="row">
                                <div class="col-xs-1">
                                    {{ $story['Views'] }}
                                </div>
                                <div class="col-xs-11">
                                    @if (array_key_exists('image', $story) && $story['image'] != 'none') 
                                        <img class='pull-right storyImage' width='80px' src='{{ $story["image"] }}'/ >
                                    @endif
                                    <span class='storyHeadlineBold'> {{ $story['headline'] }}</span><br>
                                    <span>{{ $story['name'] }}</span><br>
                                    <a href='{{ $story["link"] }}' target='_blank'>View story</a>
                                </div>
                            </div>
                        </li>
                    @endforeach
                @endif
            </ol>
        </div>
	</div>
</div>