<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Location</title>
<meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
<link href="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.css" rel="stylesheet">
<script src="https://api.mapbox.com/mapbox-gl-js/v2.1.1/mapbox-gl.js"></script>
<style>
body { margin: 0; padding: 0; }
#map { position: absolute; top: 0; bottom: 0; width: 100%; }
</style>
</head>
<body>
<div id="map"></div>
 
<script>
	// TO MAKE THE MAP APPEAR YOU MUST
	// ADD YOUR ACCESS TOKEN FROM
	// https://account.mapbox.com
	mapboxgl.accessToken = 'pk.eyJ1IjoiYW5hbW9sa2hhbmFsIiwiYSI6ImNraXNlemNtMDB3cWEzMG55c3h6ZnF2NmoifQ.AGth90CPMwVVSkp93EXmGg';
var map = new mapboxgl.Map({
container: 'map',
style: 'mapbox://styles/mapbox/streets-v11',
center: [{{$long}}, {{$lat}}],
zoom: 13
});
 
var marker = new mapboxgl.Marker()
.setLngLat([{{$long}}, {{$lat}}])
.addTo(map);
</script>
 
</body>
</html>