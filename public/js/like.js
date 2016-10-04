$(document).ready(function()
{
    var id = $('#idView').text();
    console.log(id);
    $('#like').on('click', function()
    {
        $.post('/like' , { id : id }, function(data)
        {
            console.log('ok');
        });
    })
});