$(document).ready(function()
{
    var id = $('#idView').text();
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
        $.post('/like' , { id : id }, function(data)
        {
            if (data.error == 0)
            {
                console.log('toto');
                $('#like').html('Unlike <span class="glyphicon glyphicon-thumbs-down"></span>');
            }
            else if (data.error == 2)
            {
                $('#like').html('Like <span class="glyphicon glyphicon-thumbs-up"></span>');
            }
            console.log(data);
        }, 'json');
    })
});