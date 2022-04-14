$("form").submit(function(event) {
    var username = $('#username').val();
    var password = $('#password').val();
    var confirmPassword = $('#confirm-password').val();

    // post to controller
    $.post("controllers/auth/register.php", {'username':username, 'password':password, 'confirm-password':confirmPassword}, function(data) {
        if (data.code == 1) {
            alert(data.message);
            setTimeout(function(){
                window.location.href = 'login.php';
            }, 2000);
        } else {
            alert(data.errors);
        }
    });

    event.preventDefault();
});