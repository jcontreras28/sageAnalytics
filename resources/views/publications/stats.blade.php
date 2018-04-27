@extends('layouts.app')

@section('content')
<div class="container">

    <h2>Stats for {{$pubData->name}}  {{$pubData->GAProfileId }}</h2>

    <div class="row" style="margin-top: 20px">
        <div class="col-xs-12">
            <span class="total-page-views"></span>
        </div>
        <div class="col-sx-12">
            <?php //include __DIR__ . '/dailyCompareTemplate.php'; ?>
        </div>
    </div>
    <hr></hr>

    <ul class="nav nav-tabs">
        
		<li class="active">
			<a href="#storyTab" data-toggle="tab">Top 200 stories today</a>
		</li>
		<li>
		    <a href="#sectionTab" data-toggle="tab">Top sections today</a>
		</li>
		<li>
			<a href="#realTimeTab" data-toggle="tab">Real-time</a>
		</li>
		<li>
			<a href="#historicalTab" data-toggle="tab">Historical</a>
		</li>
		<li>
			<a href="#promosTab" data-toggle="tab">Promos/SS</a>
		</li>
		<li>
			<a href="#searchTab" data-toggle="tab">Search</a>
		</li>

	</ul>
	

	@if (array_key_exists('errors', $results)) 
		<ul class="extra-margin-top no-bullet-list">

			@foreach($results['errors'] as $error) 
				<li class="alert alert-danger" role="alert">{{ $error }}</li>
			@endforeach

		</ul>
	@endif

	<div id='storiesPanel'>

		<div id="top200Total" style="display:none">{{ number_format($rowsAllPages[0]['metrics'][0][0]) }}</div>
		<div id="top200TotalUniques" style="display:none">{{ number_format($rowsAllPages[0]['metrics'][0][2]) }}</div>
		<div id="top200StoryTotal" style="display:none">{{ number_format($results['storyTotal']) }}</div>
		<div id="top200StoryTotalUniques" style="display:none">{{ number_format($results['storyUniqueTotal']) }}</div>

		<ul>
			<li class="list-group-item">
				<div class="row title">
					<div class="col-xs-1">Views</div>
        			<div class="col-xs-1">Visitors</div>
					<div class="col-xs-7">Headline, name and author</div>'
        			<div class="col-xs-3">Referrers (Top 6)</div>
				</div>
			</li>
		</ul>

		<ol class="custom-counter">
			@foreach($results["articles"] as $key => $story )
				@if ($loop->index > 200) 
					@break
				@endif
				
				<li class="list-group-item list-group-item-ordered">
					<div class="row">
						<div class="col-xs-1" id="storyViews{{ $loop->index }}">{{ $story['Views']}}</div>
						<div class="class-xs-1" id="storyUniques{{ $loop->index }}">{{ $story['Uniques'] }}</div>
						<div class="col-xs-7">
							@if (array_key_exists('image', $story) && $story['image' != 'none']) 
								<img class='pull-left storyImage' width='80px' src='http://www.bendbulletin.com{{ $story["image"] }}' id='storyThumb{{ $loop->index }}' / >
							@endif
							<span id='storyHeadline{{ $loop->index }}' class='storyHeadlineBold'>{{ $story['headline'] }}</span><br>
        					<span id='storyName{{ $loop->index }}'>{{ $story['name'] }}</span><br>
        					<span id='storyAuthor'>{{ $story['author'] }}</span> - 
							<a href='{{ $story["link"] }}' target='_blank' id='storyUrl{{ $loop->index }}'>View story</a>
						</div>
						<div class="referrer-row col-xs-3" style="font-size:.9em">
							<span id='storyRefs{{ $loop->index }}'>
								@foreach($story['referrers'] as $subKey => $ref)
									@if ($loop->index == 0)
										{{ $ref }} - {{ $subKey }}
									@else	
										| {{ $ref }} - {{ $subKey }}
									@endif
									@if ($loop->index > 5)
										@break
									@endif
								@endforeach
							</span>
						</div>
					</div>
				</li>
			@endforeach
		</ol>
	</div>

	<pre>
	{{ print_r($returnArray) }}
	</pre>
</div>

@endsection