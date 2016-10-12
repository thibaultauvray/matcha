function unread(id)
{
    console.log(id);
    $.post('/readNotif', {'id' : id }, function(data)
    {
        $('#unread').html(data.nb);
    }, 'json');
}

$(document).ready(function()
{


    // TODO DEBUG NOTIF UNREAD

    setInterval(function(){
        $.get('/getUnreadNotif', function(data){
            $('.notifUnread').html(data);
            $.getJSON('/getCountNotif', function(data)
            {
                $('#unread').html(data.nb);
            });
        }, 'html');
    }, 3000);
});