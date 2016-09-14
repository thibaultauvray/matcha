// API KEY AIzaSyBwZXJkJPw3GtRcMhXXaBonIsmg2TYvAAY

$(document).ready(function()
{
  function maPosition(position) {
  var infopos = "Position déterminée :\n";
  infopos += "Latitude : "+position.coords.latitude +"\n";
  infopos += "Longitude: "+position.coords.longitude+"\n";
  infopos += "Altitude : "+position.coords.altitude +"\n";
  $.getJSON( "https://maps.googleapis.com/maps/api/geocode/json?latlng="+ position.coords.latitude +","+position.coords.longitude+"&key=AIzaSyBwZXJkJPw3GtRcMhXXaBonIsmg2TYvAAY", function( data ) {
  		console.log(data.results[0].address_components[6].long_name);
  		var id = document.getElementById('idUser').dataset.id;
  		var zipCode = data.results[0].address_components[6].long_name;
  		$.ajax({
  			url : "/updateZipCode",
  			type : "POST",
  			 data: { id: id, zip: zipCode, latitude: position.coords.latitude, longitude: position.coords.longitude},
  			success : function(data){
  				console.log(data)
  			}
  		})

  });
  // $.ajax({
  // 		url : "https://maps.googleapis.com/maps/api/geocode/json?latlng="+ position.coords.latitude +","+position.coords.longitude+"&key=AIzaSyBwZXJkJPw3GtRcMhXXaBonIsmg2TYvAAY",
  // 		type : "GET",
  // 		datatype : 'json',
  // 		success : function(data){ // success est toujours en place, bien sûr !
  //      		console.log(data.address_components[3]);
  //      		console.log(data.results.address_components[3]);
  //      	},
  // })
}

if(navigator.geolocation)
{
  navigator.geolocation.getCurrentPosition(maPosition);	
};


});