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
                        console.log(arrayCity);
                        if (arrayCity.length == 3)
                        {
                            var city = arrayCity[1];
                            console.log(city.indexOf("Paris"));
                            if (city.indexOf("Paris") != -1)
                            {
                                var arron = arrayCity[0].slice(0,2);
                                var city = "Paris " + arron;
                                console.log("CITY" + city);

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
                                    data: {city: city, lng: lng, lat: lat},
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


