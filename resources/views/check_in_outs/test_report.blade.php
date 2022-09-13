@extends('layouts.app')
@section('css')

    <link href='https://api.mapbox.com/mapbox.js/v3.2.1/mapbox.css' rel='stylesheet' />
    <style>
        .mapCss {
            /* position: absolute;
                    top: 0;
                    bottom: 0; */
            width: 100%;
            height: 400px;
            margin-bottom: 20px;
        }

        .info {
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .info div {
            background: #fff;
            padding: 10px;
            border-radius: 3px;
        }

    </style>
@endsection
@section('content')

    <div id="reports" class="row">
        {{-- Map will be generated through javascript --}}
    </div>
@endsection
@section('third_party_scripts')
    <script src='https://api.mapbox.com/mapbox.js/v3.2.1/mapbox.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.8.0"></script>
    <script>
        function generateMap(key, data) {
            var data = {!! json_encode($positions) !!};
            var saledata = {!! json_encode($temp_sale) !!};
            var centervalue = Math.floor(data.length / 2);
            //position has all the data, which has been sent through the controller
            L.mapbox.accessToken =
                "pk.eyJ1Ijoic2FuYW1zaHJlc3RoYTEyMyIsImEiOiJjanpqcDhwaG0wNjNxM291aXZybjd3eng2In0.KOeiGVngAUlaFdVxsKFaNg";

            var map = L.mapbox
                .map('reports')
                .setView(data[centervalue], 13)
                .addLayer(
                    L.mapbox.styleLayer("mapbox://styles/mapbox/streets-v11")
                );
            map.scrollWheelZoom.disable();
            var myLayer = L.mapbox.featureLayer().addTo(map);
            var polyline = L.polyline([]).addTo(map);

            let geoJson = {
                type: "Feature",
                features: []
            };
            //created the separate array to store coordinate
            var latlongarr = [];
            var lonlatgarr = [];
            data.forEach(val => {
                if (val.speed > consideredValidRunningspeed) {
                    if (val.speed > over_speed_limit) {
                        busColor = 'red';
                    } else {
                        busColor = '#00a1ffd4';
                    }
                    var feature = {
                        type: "Feature",
                        properties: {
                            positionInfo: val,
                            icon: {
                                className: "", // class name to style
                                html: '<i style="position: relative; top: -13px; right:10px; transform-origin:  center; transform: rotate(' +
                                    val.course + 'deg); color:' + busColor +
                                    '" class="fa fa-angle-up fa-2x"></i>',
                                iconSize: null // size of icon, use null to set the size in CSS
                            }
                        },
                        geometry: {
                            type: "Point",
                            coordinates: [val.longitude, val.latitude]
                        }
                    };
                    polyline.addLatLng(
                        L.latLng(val.latitude, val.longitude));
                    geoJson.features.push(feature);

                    latlongarr.push([val.longitude, val.latitude]);
                    lonlatgarr.push([val.latitude, val.longitude]);
                }
            });

            myLayer.on("layeradd", function(e) {
                var marker = e.layer,
                    feature = marker.feature;
                if (feature.geometry.type == "Point")
                    marker.setIcon(L.divIcon(feature.properties.icon));
            });
            myLayer.setGeoJSON([geoJson]);
            // myLayer.setGeoJSON([geoJson,geoJson2]);
            document.getElementById('btnlt' + key)
            var animationspeed = 300;
            var play = false;
            var pausedPoint = 0;
            document.getElementById('btn' + key).onclick = function() {
                if (!play) {
                    play = true;
                    // Create a counter with a value of 0.
                    var j = pausedPoint;
                    // Create a marker and add it to the map.
                    var marker = L.circleMarker(lonlatgarr[0], {
                        icon: L.mapbox.marker.icon({
                            'marker-color': '#f86767'
                        })
                    }).addTo(map);

                    function tick() {
                        // Set the marker to be at the same point as one
                        // of the segments or the line.
                        marker.setLatLng(L.latLng(
                            lonlatgarr[j][0],
                            lonlatgarr[j][1]));
                        map.setView([lonlatgarr[j][0],
                            lonlatgarr[j][1]
                        ]);

                        // Move to the next point of the line
                        // until `j` reaches the length of the array.
                        new_polyline.addLatLng(
                            L.latLng(lonlatgarr[j][0],
                                lonlatgarr[j][1]));

                        if (++j < lonlatgarr.length) {
                            if (play) {
                                setTimeout(tick, animationspeed);

                                var feature = geoJson.features[j]
                                var content =
                                    "<div><strong>Server Time: " +
                                    feature.properties.positionInfo.servertime +
                                    "</strong> <br><strong>Speed: " +
                                    feature.properties.positionInfo.speed +
                                    "</strong> <br><strong>Valid: " +
                                    feature.properties.positionInfo.valid +
                                    "</strong></div>";
                                info.innerHTML = content;




                            } else {
                                pausedPoint = j - 1
                                marker.remove()
                            }
                        } else {
                            myLayer.setGeoJSON([geoJson]);
                            map.fitBounds(lonlatgarr);
                            play = false
                        }

                    }

                    // geoJson2.features[0].geometry.coordinates = [];
                    // map.removeLayer(myLayer)
                    myLayer.setGeoJSON([]);
                    map.removeLayer(polyline)
                    var new_polyline = L.polyline([]).addTo(map);
                    tick();
                }



            }
            document.getElementById('btnlt' + key).onclick = function() {
                animationspeed = animationspeed * 2
            }
            document.getElementById('btngt' + key).onclick = function() {
                animationspeed = animationspeed / 2
            }
            document.getElementById('btnpause' + key).onclick = function() {
                play = false;
            }


            if (lonlatgarr.length > 0) {
                map.fitBounds(lonlatgarr);
            }

            // Listen for individual marker click.
            myLayer.on("click", function(e) {
                // Force the popup closed.
                e.layer.closePopup();
                var feature = e.layer.feature;
                var content =
                    "<div><strong>Server Time: " +
                    feature.properties.positionInfo.servertime +
                    "</strong> <br><strong>Speed: " +
                    feature.properties.positionInfo.speed +
                    "</strong> <br><strong>Valid: " +
                    feature.properties.positionInfo.valid +
                    "</strong></div>";
                info.innerHTML = content;
            });
            // Clear the tooltip when map is clicked.
            map.on("zoom", () => {
                info.innerHTML = "";
            });
        }

        function csc(cs) {
            if (cs == ps) {
                return false
            } else {
                ps = cs
                return true
            }
        }

        function checkState(speed) {
            if (speed <= 5) {
                return 'stop';
            } else {
                return 'running';
            }
        }
    </script>
@endsection
