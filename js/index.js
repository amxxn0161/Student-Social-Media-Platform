$(document).ready(function(){
	
	// GET from controller
    $.get("controllers/groupchat/populateGroupchats.php", function(data) {
        if (data.code == 0) {
            alert(data.errors);
        } else {
            for (var i = data.data.length - 1; i >= 0; i--) {
                data.data[i]
                $('#groupchats-list').append('<a href="groupchat.php?id=' + data.data[i].id + '" class="list-group-item list-group-item-action flex-column align-items-start"> <div class="d-flex w-100 justify-content-between"> <h5 class="mb-1">' + data.data[i].name + '</h5> </div><p class="mb-1">' + data.data[i].description + '</p></a>');
            }
        }
    });


});