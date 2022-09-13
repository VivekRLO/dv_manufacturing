@extends('layouts.app')
@section('third_party_stylesheets')
    <meta charset="utf-8">
    <title>Display a popup on click</title>
    <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no">
    <link href="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.css" rel="stylesheet">
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js"></script>

    <style>
        #map {
            position: absolute;
            top: 0;
            bottom: 0;
            width: 100%;
            height: 700px;
        }

        .mapboxgl-popup {
            width: 200px;
            height: 200px;
        }

    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Staff Detail:</h3>
                </div>
                <div class="row card-body">
                    <div class="col-md-6">
                        <label>Staff Name : {{ $checkinout->salesOfficer->name }}</label>
                    </div>
                    <div class="col-md-6">
                        <label>Date :
                            {{ Illuminate\Support\Str::substr($checkinout->checkin_device_time, 0, 10) }}</label>
                    </div>
                    <div class="col-md-6">
                        <label>Check In :
                            {{ Illuminate\Support\Str::substr($checkinout->checkin_device_time, 10) }}</label>
                    </div>
                    <div class="col-md-6">
                        <label>Check Out :
                            {{ Illuminate\Support\Str::substr($checkinout->checkout_device_time, 10) }}</label>
                    </div>
                </div>
            </div>
        </div>
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
                var data = {!! json_encode($positions) !!};
                var saledata = {!! json_encode($temp_sale) !!};
                var checkout = {!! json_encode($checkout) !!}

                var centervalue = Math.floor(data.length / 2);
                // TO MAKE THE MAP APPEAR YOU MUST
                // ADD YOUR ACCESS TOKEN FROM
                // https://account.mapbox.com
                mapboxgl.accessToken =
                    'pk.eyJ1IjoiYW5hbW9sa2hhbmFsIiwiYSI6ImNraXNlemNtMDB3cWEzMG55c3h6ZnF2NmoifQ.AGth90CPMwVVSkp93EXmGg';
                const map = new mapboxgl.Map({
                    container: 'map',
                    style: 'mapbox://styles/mapbox/streets-v11',
                    center: data[centervalue],
                    zoom: 15
                });


                map.on('load', () => {
                        map.loadImage(
                            'https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png',
                            (error, image) => {
                                if (error) throw error;
                                map.addImage('custom-marker', image);
                                map.addSource('route', {
                                    'type': 'geojson',
                                    'data': {
                                        'type': 'FeatureCollection',
                                        'features': [{
                                                'type': 'Feature',
                                                'properties': {
                                                    'icon': {
                                                        'className': "", // class name to style
                                                        'html': '<i style="position: relative; top: -13px; right:10px; transform-origin:  center;" class="fa fa-angle-up fa-2x"></i>',
                                                        'iconSize': null // size of icon, use null to set the size in CSS
                                                    }
                                                },
                                                'geometry': {
                                                    'type': 'LineString',
                                                    'coordinates': data,
                                                }
                                            },
                                            {
                                                'type': 'Feature',
                                                'geometry': {
                                                    'type': 'MultiPoint',
                                                    'coordinates': saledata
                                                }
                                            }
                                        ]
                                    }
                                });
                                map.addLayer({
                                    'id': 'route',
                                    'type': 'line',
                                    'source': 'route',
                                    'layout': {
                                        'line-join': 'round',
                                        'line-cap': 'round'
                                    },
                                    'paint': {
                                        'line-color': '#888',
                                        'line-width': 8
                                    }
                                });

                                map.addLayer({
                                    'id': 'park-volcanoes',
                                    'type': 'circle',
                                    'source': 'route',
                                    'paint': {
                                        'circle-radius': 6,
                                        'circle-color': '#B42222'
                                    },
                                    'filter': ['==', '$type', 'LineString']
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
// console.log(coordinates);
                                    // Ensure that if the map is zoomed out such that multiple
                                    // copies of the feature are visible, the popup appears
                                    // over the copy being pointed to.
                                    while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                                        coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                                    }

                                    $.ajax({
                                        url: 'get-outlet/' + coordinates[0] + '/' + coordinates[
                                            1],
                                        type: 'get',
                                        success: function(response) {

                                            new mapboxgl.Popup()
                                                .setLngLat(coordinates)
                                                .setHTML(response)
                                                .addTo(map);

                                        },
                                    });

                                });

                                // Change the cursor to a pointer when the mouse is over the points layer.
                                map.on('mouseenter', 'points', () => {
                                    map.getCanvas().style.cursor = 'pointer';
                                });

                                // Change it back to a pointer when it leaves.
                                map.on('mouseleave', 'points', () => {
                                    map.getCanvas().style.cursor = '';
                                });
                                // Set marker options.
                                const checkin = new mapboxgl.Marker({
                                        color: "green",
                                        draggable: false
                                    }).setLngLat(data[0])
                                    .setPopup(new mapboxgl.Popup().setHTML("Check In")) // add popup
                                    .addTo(map);
                                if (checkout == "true") {
                                    const checkout = new mapboxgl.Marker({
                                            color: "red",
                                            draggable: false
                                        }).setLngLat(data[data.length - 1])
                                        .setPopup(new mapboxgl.Popup().setHTML("Check Out"))
                                        .addTo(map);
                                }
                            });
                    });

            });
        </script>
    @endsection
