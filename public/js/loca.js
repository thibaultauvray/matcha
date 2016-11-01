/**
 * Created by tauvray on 11/1/16.
 */
$(document).ready(function ()
{
    var id = document.getElementById('idUser').dataset.id;
    $.getJSON('/isNotLoca', function (data)
    {
        if (data.response == 0)
        {
            $.get("http://ipinfo.io", function (response)
            {
                console.log("Updated");
                var id = document.getElementById('idUser').dataset.id;
                $.ajax(
                    {
                        url: "/updateZipCode",
                        type: "POST",
                        data: {
                            id: id,
                            city: response.city,
                            zip: response.postal,
                            latitude: response.loc.split(',')[0],
                            longitude: response.loc.split(',')[1],
                            prec: 1
                        },
                        success: function (data)
                        {
                            console.log("TIPIAK updated");
                        }
                    });
            }, "jsonp");
        }
    });
});