// API KEY AIzaSyBwZXJkJPw3GtRcMhXXaBonIsmg2TYvAAY

$(document).ready(function()
{
	function maPosition(position) 
	{
		var infopos = "Position déterminée :\n";
		infopos += "Latitude : "+position.coords.latitude +"\n";
		infopos += "Longitude: "+position.coords.longitude+"\n";
		infopos += "Altitude : "+position.coords.altitude +"\n";
		var id = document.getElementById('idUser').dataset.id;

		$.getJSON("/updateLocation", {id : id}, function (data) 
		{
			if(data.updated)
			{
				console.log("Location updated");
				$.getJSON( "https://maps.googleapis.com/maps/api/geocode/json?latlng="+ position.coords.latitude +","+position.coords.longitude+"&key=AIzaSyBwZXJkJPw3GtRcMhXXaBonIsmg2TYvAAY", function( data ) 
				{
			  		var id = document.getElementById('idUser').dataset.id;
			  		var zipCode = data.results[0].address_components[6].long_name;
			  		console.log(data.results[0]);
			  		var city = data.results[0].address_components[2].long_name;
			  		$.ajax(
			  		{
			  			url : "/updateZipCode",
			  			type : "POST",
			  			 data: { id: id, city : city, zip: zipCode, latitude: position.coords.latitude, longitude: position.coords.longitude},
			  			success : function(data){
			  				console.log(data)
			  			},
			  		});
				});
			}
		});
	}

	function erreurPosition(error) 
	{
		var id = document.getElementById('idUser').dataset.id;

		$.getJSON("/updateLocation", {id : id}, function (data) 
		{
			if (data.updated)
			{
		    	$.get("http://ipinfo.io", function (response) {
				var id = document.getElementById('idUser').dataset.id;
				console.log(response);
				$.ajax(
				{
					url : "/updateZipCode",
					type : "POST",
					data: { id : id, city : response.city, zip : response.postal, latitude : response.loc.split(',')[0], longitude : response.loc.split(',')[1], prec : 1 },
					success : function(data){
						console.log(data);
					}
				});
				}, "jsonp");
			}
		});

	}
	

var options = 
{
	timeout: 5000
};

if(navigator.geolocation)
{
  navigator.geolocation.getCurrentPosition(maPosition, erreurPosition, options);	
};


});