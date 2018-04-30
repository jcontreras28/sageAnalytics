
	
	@if (array_key_exists('errors', $results)) 
		<ul class="extra-margin-top no-bullet-list">

			@foreach($results['errors'] as $error) 
				<li class="alert alert-danger" role="alert">{{ $error }}</li>
			@endforeach

		</ul>
	@endif

		<div id="top200Total" class="display-hidden-start">{{ number_format($dayTotalViews) }}</div>
		<div id="top200TotalUniques" class="display-hidden-start">{{ number_format($dayTotalUniques) }}</div>
		<div id="top200StoryTotal" class="display-hidden-start">{{ number_format($totalStoriesViews) }}</div>
		<div id="top200StoryTotalUniques" class="display-hidden-start">{{ number_format($totalStoriesUniques) }}</div>

		<ol class="custom-counter">
			@foreach($results["articles"] as $key => $story )
				@if ($loop->index > 200) 
					@break
				@endif
				
				<li class="list-group-item list-group-item-ordered">
					<div class="row">
						<div class="col-xs-1" id="storyViews{{ $loop->index }}">{{ $story['Views']}}</div>
						<div class="col-xs-1" id="storyUniques{{ $loop->index }}">{{ $story['Uniques'] }}</div>
						<div class="col-xs-7">
							@if (array_key_exists('image', $story) && $story['image'] != 'none') 
								<img class='pull-left storyImage' width='80px' src='{{ $story["image"] }}' id='storyThumb{{ $loop->index }}' / >
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

		<pre>
		{{ print_r(count($results['articles']))}}
		</pre>
		<pre>
		{{ print_r($results) }}
		</pre>
</div>
