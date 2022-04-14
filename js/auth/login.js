$(document).ready(function(){
	$("form").submit(function(){
		var username = $('#username').val();
		var password = $('#password').val();

		// post to controller
	    $.post("controllers/auth/login.php", {'username':username, 'password':password}, function(data) {
	        if (data.code == 1) {
	            setTimeout(function(){
	                window.location.href = 'index.php';
	            }, 100);
	        } else {
	        	alert(data.errors);
	        }
	    });

	    event.preventDefault();
	});
});