@extends('layouts.app')
@section('third_party_stylesheets')
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js"></script>

    <style>
        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
            height: 900px;
        }

        .mapboxgl-popup {
            width: 200px;
            height: 200px;
        }

    </style>
@endsection
@section('content')
    <div class="col-md-12">
        <div id="map">
            {{-- Map will be generated through javascript --}}
        </div>
    </div>

@endsection
@section('third_party_scripts')
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js"></script>
    <script>
        $(document).ready(function() {
            var data = {!! json_encode($data) !!};
            var centervalue = Math.floor(data.length / 2);

            // TO MAKE THE MAP APPEAR YOU MUST
            // ADD YOUR ACCESS TOKEN FROM
            // https://account.mapbox.com
            mapboxgl.accessToken =
                'pk.eyJ1IjoiYW5hbW9sa2hhbmFsIiwiYSI6ImNraXNlemNtMDB3cWEzMG55c3h6ZnF2NmoifQ.AGth90CPMwVVSkp93EXmGg';
            const map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: [84.12163709774656,28.091781499174257],
                zoom: 7
            });
            const places = {
                'type': 'FeatureCollection',
                'features':data
            };

            map.on('load', () => {
                map.loadImage(
                    'https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png',
                    (error, image) => {
                        if (error) throw error;
                        map.addImage('custom-marker', image);
                        map.addSource('route', {
                            'type': 'geojson',
                            'data': places
                        });

                        map.addLayer({
                            'id': 'points',
                            'type': 'symbol',
                            'source': 'route',
                            'layout': {
                                'icon-image': 'custom-marker',
                                // get the title name from the source's "title" property
                                'text-field': ['get', 'title'],
                                'text-font': [
                                    'Open Sans Semibold',
                                    'Arial Unicode MS Bold'
                                ],
                                'text-offset': [0, 1.25],
                                'text-anchor': 'top',
                                'icon-allow-overlap': true
                            },
                            'filter': ['==', '$type', 'Point']
                        });
                        // When a click event occurs on a feature in the points layer, open a popup at the
                        // location of the feature, with description HTML from its properties.
                        map.on('click', 'points', (e) => {
                            // Copy coordinates array.
                            const coordinates = e.features[0].geometry.coordinates.slice();
                            const description = e.features[0].properties.description;
                            // Ensure that if the map is zoomed out such that multiple
                            // copies of the feature are visible, the popup appears
                            // over the copy being pointed to.
                            while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                                coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                            }
                            
                            new mapboxgl.Popup()
                                .setLngLat(coordinates)
                                .setHTML(description)
                                .addTo(map);

                        });

                        // Change the cursor to a pointer when the mouse is over the points layer.
                        map.on('mouseenter', 'points', () => {
                            map.getCanvas().style.cursor = 'pointer';
                        });

                        // Change it back to a pointer when it leaves.
                        map.on('mouseleave', 'points', () => {
                            map.getCanvas().style.cursor = '';
                        });
                    });
            });

        });
    </script>
@endsection
