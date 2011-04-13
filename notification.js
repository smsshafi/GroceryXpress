var timeoutReference;
var global_duration = 4500;

function showNotification(message, duration) {
        $('#notification').stop();

        clearTimeout(timeoutReference);
        $('#notification p').html(message);
        
        $('#notification').animate({top: "0px"}, 700);
        if (typeof duration == 'undefined') {
                duration = global_duration;
        }
        else
        {
                if (duration == 0) {
                        return;
                }
        }

        timeoutReference = setTimeout("hideNotification()", duration);
}

function hideNotification() {
        $('#notification').animate({top: "-35px"}, 700);
}

$(document).ready(function(){
        $('#closenotification').click(function(){
                hideNotification();
        })

        $('#notification').mouseenter(function(){
                clearTimeout(timeoutReference);
        }).mouseleave(function(){
                timeoutReference = setTimeout("hideNotification()", global_duration);
        })

})

