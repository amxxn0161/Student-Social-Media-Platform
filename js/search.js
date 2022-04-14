$(document).ready(function(){
	
    $('#search-bar').submit(function(){
        // get query
        var queriedUsername = $('#searchBarUsername').val();

        // post to controller
        $.post("controllers/search/search.php", {'username':queriedUsername}, function(data) {
            if (data.code == 0) {
                alert(data.errors);
            } else {
                window.location.replace("/profile.php?userid=" + data.results.id);
            }
        });

        event.preventDefault();
    });


});