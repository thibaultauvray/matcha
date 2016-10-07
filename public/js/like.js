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
    var id = $('#idView').text();

    // TODO ENLEVER SA CEST MOCHE

    $.getJSON('/getLike', { id : id}, function(data)
    {
        console.log(data.error);
        if (data.error == 0)
        {
            $('#like').html('Like <span class="glyphicon glyphicon-thumbs-up"></span>');
        }
        else if (data.error == 2)
        {
            $('#like').html('Unlike <span class="glyphicon glyphicon-thumbs-down"></span>');
        }

    });

    $('#like').on('click', function()
    {
        if($(this).data('pic').length != 0)
        {
            $.post('/like', {id: id}, function (data)
            {


                if (data.error == 0)
                {
                    $('#like').html('Unlike <span class="glyphicon glyphicon-thumbs-down"></span>');
                }
                else if (data.error == 2)
                {
                    $('#like').html('Like <span class="glyphicon glyphicon-thumbs-up"></span>');
                }
                else if (data.error == -1)
                {
                    $('#like').append('<span class="alert alert-danger">Vous n\'avez pas de photo de profil</span>');
                }
            }, 'json');
        }
    })
});