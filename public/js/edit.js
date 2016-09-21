$(document).ready(function()
{
    $('#prev').on('click', function(e)
    {
    });

    $('#editForm').submit(function(e)
    {

        $.getJSON("/getCity", function(data)
        {
            var city = $('#city').val();
            if(data.city != city)
            {
                console.log("Not same");
                $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?address="+encodeURIComponent(city), function(data)
                {
                    console.log(data);
                    if(data.results.length && data.results[0].geometry)
                    {
                        var arrayCity = data.results[0].formatted_address.split(",");
                        if (arrayCity.length == 3)
                        {
                            var zipCode = arrayCity[1].split(" ")[1];
                            var city = arrayCity[1].split(" ")[2];
                            if (zipCode.slice(0,2) == "75")
                            {
                                var arron = zipCode.slice(3,5);
                                var city = city + " " + arron;
                            }
                        }
                        else if(arrayCity.length == 2)
                        {
                            var zipCode = null;
                            var city = arrayCity[0];
                        }
                        else
                        {
                            var error = 1;
                        }
                        if (data.results[0].geometry.location.lat)
                            var lat = data.results[0].geometry.location.lat;
                        else
                            var error = 1;
                        if (data.results[0].geometry.location.lng)
                            var lng = data.results[0].geometry.location.lng;
                        else
                            var error = 1;
                        if(error != 1)
                        {
                            $.ajax(
                                {
                                    url: "/updateLocationProfil",
                                    type: "POST",
                                    data: {city: city, lng: lng, lat: lat, zipCode: zipCode},
                                    success: function (data) {
                                        $('#city').val(city);
                                        $('.alert').remove();
                                        $('#city').after('<div class="alert alert-success">Localisation modifié</div>');
                                        console.log(data)
                                    },
                                });
                        }
                        else
                        {
                            $('#city').after('<div class="alert alert-danger"> Ville introuvable</div>');
                        }
                    }
                    else
                    {
                        var error = 1;
                        console.log(error);
                    }
                    console.log('error');console.log(error);
                    if(error == 1)
                    {
                        $('.alert').remove();
                        $('#city').after('<div class="alert alert-danger"> Ville introuvable</div>');
                    }
                });
            }
        });
        e.preventDefault();

    });
});


