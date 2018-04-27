

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

    function getStorySectionData(start, end) {
        //alert('hello');
        var pubId = $('.pubIdContainer').attr('id');
        console.log('pubId: ', pubId);
        var theUrl = "/pub/"+pubId.toString()+"/refresh";
        console.log('theUrl', theUrl);
        $.ajax({
            type:"GET",
            url : theUrl,
            dataType: "html",
            success : function(response) {
                $( "#storiesPanel" ).html(response);
                console.log(response);
            },
            error: function() {
                console.log('error ', response);
            }
        });
    }

    setInterval(function(){
		getStorySectionData('0daysAgo', 'today');
	}, 120000);

});