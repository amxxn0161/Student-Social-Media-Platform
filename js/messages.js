$(document).ready(function(){
	
    function loadMessages(){
        // GET from controller
        $.get("controllers/messages/loadMessages.php", function(data) {
            if (data.code == 0) {
                // clear existing errors
                $('#messages-list').empty();

                $('#messages-list').append('<div class="alert alert-danger" role="alert">' + data.errors + '</div>');
            } else {
                messages = data.data;
                // clear existing messages
                $('#messages-list').empty();
                // append new messages
                for (var i = messages.length - 1; i >= 0; i--) {
                    $('#messages-list').append('<a href="directchat.php?userid=' + messages[i].sender_id +'" class="list-group-item list-group-item-action flex-column align-items-start"> <div class="d-flex w-100 justify-content-between"> <h5 class="mb-1">' + messages[i].sender_username + '</h5> <small class="text-muted">' + messages[i].time_ago + '</small> </div><p class="mb-1">' + messages[i].message + '</p></a>');
                }
            }
        });
    }

    // on page load, load messages
    loadMessages();

    // refresh inbox every 3 seconds
    const interval = setInterval(function() {
        loadMessages();
    }, 3000);


});