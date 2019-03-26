/**
 * Set up login page
 */
function loginSetup()
{
    let loginWindow = $('#login-window');

    // Add listener to login button
    loginWindow.submit(function () {
        $('#login-button').val("Logging in...");
    });

    // Set login page background
    loginWindow.parent().css('background-image', "url('../themes/admin/media/background.png')");
}

function notificationSetup()
{
    $('#notifications-dismiss').click(function(){$('#notifications').fadeOut()});
}

$(document).ready(function(){
    loginSetup();
    notificationSetup();

    // Initialize Date pickers
    $('.date-input').datepicker({dateFormat: 'yy-mm-dd'});

    // Fade in notifications if they are present
    $('#notifications').fadeIn();
});