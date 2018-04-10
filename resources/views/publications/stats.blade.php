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
	

	@if (array_key_exists('errors', $returnArray)) 
		<ul class="extra-margin-top no-bullet-list">

			@foreach($returnArray['errors'] as $error) 
				<li class="alert alert-danger" role="alert">{{ $error }}</li>
			@endforeach

		</ul>
	@endif

	{{ print_r($returnArray) }}
</div>

@endsection