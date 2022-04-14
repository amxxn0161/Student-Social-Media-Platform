$(document).ready(function(){

	// load groupchat data in
     $.ajax({
	    url : "controllers/groupchat/loadGroupchat.php",
	    data: {'id':id},
	    type : "get",
	    async: false,
	    success : function(data) {
	    	if (data.code == 0) {
	            window.location.replace("/");
	        }

	        // populate using data
        	$('#groupchat-title').html(data.data.name);
	    }
	 });

    function loadMessages(scroll){
    	// load messages
	    $.get("controllers/groupchat/loadMessages.php", {'id':id}, function(data) {
	    	
    		// populate messages
    		var messages = data.data;

    		// clear existing messages
    		$('#chatbox').empty();

    		// load in new messages
    		for (var i = messages.length - 1; i >= 0; i--) {
    			$('#chatbox').append('<div class="alert alert-info small"> <div class="row"> <div class="col-sm-2"><a href="profile.php?userid=' + messages[i].sender_id + '">' + messages[i].username + '</a>' + ' - ' + messages[i].datetime + '</div><div class="col-sm-10">' + messages[i].message + '</div></div></div>')
    		}
	    	
	        // if set to scroll, scroll down
	        if (scroll) {
	        	// scroll to bottom of chatbox
    			$("#chatbox").scrollTop($("#chatbox")[0].scrollHeight);
	        }
	    });
    }

    // call load messages initialy
    loadMessages(true);

    // capture when message is entered
    $('#message-box').on('keypress', function(e) {
    	if (e.which == 13) {
    		// post message to controller
    		var message = $('#message-box').val();
    		$.post("controllers/groupchat/newMessage.php", {'groupchat-id': id, 'message': message}, function(data) {
    			if (data.code == 0) {
    				alert(data.errors);
    			} else if (data.code == 1) {
    				loadMessages(true);
    			}
    		})

    		// clear message box ready for new message
    		$('#message-box').val('');
    	}
    })

    // refresh chatbox every 5 seconds
    const interval = setInterval(function() {
   		loadMessages(false);
 	}, 3000);

});