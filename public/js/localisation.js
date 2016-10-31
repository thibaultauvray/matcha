// API KEY AIzaSyBwZXJkJPw3GtRcMhXXaBonIsmg2TYvAAY

$(document).ready(function()
{
	function maPosition(position)
	{
		var id = document.getElementById('idUser').dataset.id;

        $.getJSON( "https://maps.googleapis.com/maps/api/geocode/json?latlng="+ position.coords.latitude +","+position.coords.longitude+"&key=AIzaSyBwZXJkJPw3GtRcMhXXaBonIsmg2TYvAAY", function( data )
        {
            var id = document.getElementById('idUser').dataset.id;
            var zipCode = data.results[0].address_components[6].long_name;
            var city = data.results[0].address_components[2].long_name;
            $.ajax(
            {
                url : "/updateZipCode",
                type : "POST",
                 data: { id: id, city : city, zip: zipCode, latitude: position.coords.latitude, longitude: position.coords.longitude},
                success : function(data){
                    console.log("UPDATED");

                },
            });
        });
	}
	var id = document.getElementById('idUser').dataset.id;

	$('#continuer').on('click', function()
	{
		$.getJSON('/updateLocation', { id : id }, function(data)
		{
			if(data.response == false)
			{
				$.get("http://ipinfo.io", function (response) {
					var id = document.getElementById('idUser').dataset.id;
					$.ajax(
						{
							url : "/updateZipCode",
							type : "POST",
							data: { id : id, city : response.city, zip : response.postal, latitude : response.loc.split(',')[0], longitude : response.loc.split(',')[1], prec : 1 },
							success : function(data){
								console.log("TIPIAK updated");
                                document.location.href="/edit/"+id;
                            }
						});
				}, "jsonp");
			}
			document.location.href="/edit/"+id;
		});
	});

	function erreurPosition(error)
	{

    }

var options =
{
	timeout: 5000
};

if(navigator.geolocation)
{
  navigator.geolocation.getCurrentPosition(maPosition, null, options);
};


});