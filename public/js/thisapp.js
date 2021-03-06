

$(document).ready( function() {

    /*$("#role_id").on('change', function() {
        alert("role changed!");
        if ($(this).val() != 1){
            $("#publication_id option[value='0']").remove();
            $('#publicationDiv').show();
        } else {
            $('#publicationDiv').hide();
            $('#publication_id').append($('<option value="0">None</option>'));
            $('#publication_id select').val('0');
        }
    });*/

    function getRealTimeData() {

        var pubId = $('.pubIdContainer').attr('id');
        console.log('pubId: ', pubId);
        var theUrl = "/pub/"+pubId.toString()+"/realtime";
        console.log('theUrl', theUrl);

        
        $.ajax({
            type:"GET",
            url : theUrl,
            dataType: "html",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(response) {
                $('#realTimeLoading').hide();
                //console.log(response);
                $( "#realTimeContent" ).html(response);

            },
            error: function() {
                console.log('error ', response);
            }
        });
    }

    function getSectionData(start, end, pubId) {
       
        console.log('pubId section refresh: ', pubId);
        var theUrl = "/pub/"+pubId.toString()+"/sectionRefresh";
        console.log('theUrl section refresh', theUrl);
        $.ajax({
            type:"GET",
            url : theUrl,
            dataType: "html",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(response) {
				$('#sectionLoading').hide();
                $( "#topSectionsContent" ).html(response);
                //console.log(response);
            },
            error: function() {
                console.log('error ', response);
            }
        });
    }

    function getStorySectionData(start, end) {

        var pubId = $('.pubIdContainer').attr('id');
        console.log('pubId: ', pubId);
        var theUrl = "/pub/"+pubId.toString()+"/refresh";
        console.log('theUrl', theUrl);
        $.ajax({
            type:"GET",
            url : theUrl,
            dataType: "html",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success : function(response) {
                $('#top200Loading').hide();
                $( "#top200Content" ).html(response);
                //console.log(response);
                var totViews = $('#top200Total').html();
				var totUniques = $('#top200TotalUniques').html();
				$('.total-page-views').html("Total pageviews so far today: "+totViews+" - Uniques: "+totUniques);
				var totViews = $('#top200StoryTotal').html();
				$('.storyTotalTotalReport').html(totViews);
				totViews = $('#top200StoryTotalUniques').html();
				$('.storyTotalReportUniques').html(totViews);
				totViews = $('#top200StoryTotalDwell').html();
                getSectionData('0daysAgo', 'today', pubId);
            },
            error: function() {
                console.log('error ', response);
            }
        });
    }

    getStorySectionData('0daysAgo', 'today');
    getRealTimeData();

    setInterval(function(){
        getStorySectionData('0daysAgo', 'today');
    }, 120000);
    
    setInterval(function(){
		getRealTimeData();
	}, 15000);

});