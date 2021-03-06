@extends('layouts.app')

@section('content')
<div class="container">
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
</div>

<pre>
{{ //print_r($resultsTotalPages) }}
</pre>

@endsection
