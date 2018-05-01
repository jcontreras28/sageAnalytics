
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
	@if (array_key_exists('errors', $results)) 
		<ul class="extra-margin-top no-bullet-list">

			@foreach($results['errors'] as $error) 
				<li class="alert alert-danger" role="alert">{{ $error }}</li>
			@endforeach

		</ul>
	@endif

        <ul>
			<li class="list-group-item">
				<div class="row title">
					<div class="col-xs-1">
						Views
					</div>
					<div class="col-xs-1">
						Uniques
					</div>
					<div class="col-xs-7">
						Section Name
					</div>
					<div class="col-xs-3">
						Referrers (top 5)
					</div>

				</div>
			</li>
		</ul>

		<ol class="custom-counter sectionDataList">
			@foreach($results["sections"] as $key => $section)
				@if ($loop->index > 200) 
					@break
				@endif
				
				<li class="list-group-item">
                    <div class="row">
                        <div class="col-xs-1">
                            {{ $section['Views']}}
                        </div>
                        <div class="col-xs-1">
                            {{ $section['Uniques'] }}
                        </div>
                        <div class="col-xs-7">
                            {{ $key }}
                        </div>
                        <div class="referrer-row col-xs-3">

                            @foreach($section['referrers'] as $subKey => $ref)
                                @if ($loop->index == 0)
                                    {{ $ref }} - {{ $subKey }}
                                @else	
                                    | {{ $ref }} - {{ $subKey }}
                                @endif
                                @if ($loop->index > 5)
                                    @break
                                @endif
                            @endforeach
                        </div>
                    </div>
                </li>
			@endforeach
		</ol>


		<pre>
		{{ print_r($results) }}
		</pre>
</div>
