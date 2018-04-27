@extends('layouts.app')

@section('content')
<div class="container pubIdContainer" id="{{$pubData->id}}">

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
	
	<div class="tab-content">
		<div class="tab-pane fade in active" id="storyTab">
			<div id='top200Loading' class='aLoadingDiv'>
				<img src="./images/large-loading.gif" />
			</div>
			<div class="tab-pane fade in active well">
				<ul>
					<li class='list-group-item' style='padding-left: 0px;'>
						<span class='storyTotalReportWrap totalsReport'>
							STORY STATS TODAY - Pageviews: <span class='storyTotalTotalReport'></span>
							Uniques: <span class='storyTotalReportUniques'></span>
							Dwell time: <span class='storyTotalReportDwell'></span>
						</span>
					</li>
				</ul>


				<span id="top200Content"></span>
			</div>
		</div>
		<div class="tab-pane fade" id="sectionTab">
			<div id='sectionLoading' class='aLoadingDiv'>
				<img src="./images/large-loading.gif" />
			</div>
		<div class="tab-pane fade in active well" id="topSectionsContent"></div>
	</div>
</div>

@endsection