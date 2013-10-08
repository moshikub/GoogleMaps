<?php
	$api = "AIzaSyC-qh8K5g5oIYvulyBCtiyk4SA3h__Tp7c";
?>
<!DOCTYPE html>
<html>
  	<head>
    	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<style type="text/css">
        	html { height: 100% }
          	body { height: 100%; margin: 0; padding: 0 }
          	#mapdiv { height: 90% }
        </style>
  	</head>
  	<body>
    <form id="mapform" action="#">
      <p>
        <input id="mapinput" type="text" class="inputbox" style="width:300px;" value="Bangkok, Thailand" maxlength="100" />
        <input type="submit" class="button" value="ค้นหา" />
      </p>
    </form>
    <div id="mapdiv"></div>
    <div id="mapoutput" style="background-color: #FFDD22;font-weight: bold;">Latitude,Longitude:</div>
    <script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?sensor=false&amp;language=th"></script>
    <script type="text/javascript">
        google.maps.event.addDomListener(window, "load", function() {
			var map = new google.maps.Map(document.getElementById("mapdiv"), {
				center: new google.maps.LatLng(13.724717, 100.633072),
				zoom: 10,
				mapTypeId: google.maps.MapTypeId.ROADMAP
			});
			var marker = new google.maps.Marker({
				position: map.getCenter(),
				draggable: true,
				map: map
			});
			google.maps.event.addListener(map, "idle", function() {
				marker.setPosition(map.getCenter());
				document.getElementById("mapoutput").innerHTML = map.getCenter().lat().toFixed(6) + "," + map.getCenter().lng().toFixed(6);
			});
			google.maps.event.addListener(marker, "dragend", function(mapEvent) {
				map.panTo(mapEvent.latLng);
			});
			var geocoder = new google.maps.Geocoder();
			google.maps.event.addDomListener(document.getElementById("mapform"), "submit", function(domEvent) {
				domEvent.returnValue = false;
				geocoder.geocode({
				address: document.getElementById("mapinput").value
			}, function(results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					var result = results[0];
					document.getElementById("mapinput").value = result.formatted_address;
					if (result.geometry.viewport) {
						map.fitBounds(result.geometry.viewport);
					}
					else {
						map.setCenter(result.geometry.location);
					}
				} else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
					alert("Sorry, the geocoder failed to locate the specified address.");
				} else {
					alert("Sorry, the geocoder failed with an internal error.");
				}
			});
			});
		});
    </script>
	</body>
</html>