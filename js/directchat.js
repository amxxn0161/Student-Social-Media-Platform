$(document).ready(function(){

	$.get('controllers/messages/getUserInfo.php', {'userid': recipientid}, function(data) {
		// if false user ID, redirect
		if (data.code == 0) {
			window.location.replace("/");
		}

		$('#chatTitle').html('Send a message to: ' + data.data.username);
	})

	// capture when message is entered
    $('#message-box').on('keypress', function(e) {
    	if (e.which == 13) {
    		// post message to controller
    		var message = $('#message-box').val();
    		$.post("controllers/messages/newMessage.php", {'recipient-id': recipientid, 'message': message}, function(data) {
    			if (data.code == 0) {
    				alert(data.errors);
    			} else if (data.code == 1) {
    				$('#chatContainer').empty();
    				$('#chatContainer').html('<div class="alert alert-success" role="alert"> ' + data.message + ' </div>');
    				setTimeout(function(){
		                window.location.href = 'messages.php';
		            }, 2000);
    			}
    		})

    		// clear message box ready for new message
    		$('#message-box').val('');
    	}
    })

});