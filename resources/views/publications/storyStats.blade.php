
	
	@if (array_key_exists('errors', $results)) 
		<ul class="extra-margin-top no-bullet-list">

			@foreach($results['errors'] as $error) 
				<li class="alert alert-danger" role="alert">{{ $error }}</li>
			@endforeach

		</ul>
	@endif

		


		<pre>
		{{ print_r(count($results['articles']))}}
		{{ print_r($results) }}
		</pre>
</div>
