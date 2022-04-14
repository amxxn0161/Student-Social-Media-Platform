$(document).ready(function(){
	
	// post to controller
    $.post("controllers/search/search.php", {'userid':userid}, function(data) {
        if (data.code == 0) {
            window.location.replace("/");
        }
        $('#username').html(data.results.username);
        $('#joined-on').html("Joined on: " + data.results.joined_on);
        $('#direct-message').attr('href', "directchat.php?userid=" + data.results.id);
    });


});