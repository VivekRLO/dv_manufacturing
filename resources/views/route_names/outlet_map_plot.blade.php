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

        .marker{
            background-image: url('');
            background-size: cover;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            cursor: pointer;
        }

    </style>
@endsection

@section('content')
    <div class="row p-3">
        <div class="col-md-12">
            <div class="card" style="margin-bottom: 0.2rem;">
                <div class="card-header d-sm-flex align-items-center justify-content-between">
                    <div class="mr-auto">
                        <h3>Outlet Detail</h3>
                    </div>
                </div>
                <div class="row card-body">
                    <div class="col-md-12">
                        <label>Route : {{ $route[0]??"No Route Outlets" }}</label>
                    </div>
                    <div class="col-md-4">
                        <label>Total Outlets : 
                            @if (empty($route[0]) == null)
                                {{ $allroute->outlets->where('flag', 0)->count() }}
                            @else
                                {{ $allroute->where('flag', 0)->count() }}
                            @endif
                        </label>
                    </div>
                    <div class="col-md-6">
                        
                        <label>Known Location : {{ sizeOf($positions) }}</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div id="map">
                {{-- Map will be generated through javascript --}}
            </div>
        </div>
        <div class="col-md-2">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Outlets</h3>
                </div>
                <div class="card-body" style="max-height: 650px; overflow-y:auto;">
                    <table>
                        <tr>
                            <th>Name</th>
                            @if(Auth::user()->role == 0)
                                <th>Action</th>
                            @endif
                        </tr>
                        @php
                            if (!$route->isEmpty()){
                                $allroute = $allroute->outlets->where('flag', 0);
                            }else{
                                $allroute = $allroute->where('flag', 0);
                            }   
                        @endphp
                        @foreach ($allroute as $outlet)
                            <tr>
                                <td>{{ $outlet->name }}</td>
                                @if(Auth::user()->role == 0)
                                    <td>
                                        <!-- Button trigger modal -->
                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal" data-whatever="{{ $outlet->id }}">
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <!-- Modal -->
                                        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                              <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Transfer Outlet: </h5>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form>
                                                            <div class="form-group">
                                                                <label for="recipient-name" class="col-form-label">Route:</label>
                                                                <select id="route_id" name="route_id" class="form-control">
                                                                    @foreach ($routes as $route)
                                                                        <option value="{{ $route->id }}">{{ $route->routename }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                        <button type="button" class="btn btn-primary" onclick="changeRoute()">Change</button>
                                                    </div>
                                              </div>
                                            </div>
                                        </div>
                                        
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>

    
@endsection

{{-- Map Begins --}}
@section('third_party_scripts')
    <script src="https://api.mapbox.com/mapbox-gl-js/v2.4.1/mapbox-gl.js"></script>
    
     <script>
        $(document).ready(function() {

            $('#exampleModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget) // Button that triggered the modal
                window.recipient = button.data('whatever') // Extract info from data-* attributes
                // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
                // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
                console.log(window.recipient)
                var modal = $(this)
                modal.find('.modal-title').text('Tansfer Outlet:')
            });

            var data = {!! json_encode($positions) !!};
            var centervalue = Math.floor(data.length / 2);

            console.log(data);
            console.log(centervalue);
            console.log(data[centervalue].geometry.coordinates);

            mapboxgl.accessToken =
                'pk.eyJ1IjoiYW5hbW9sa2hhbmFsIiwiYSI6ImNraXNlemNtMDB3cWEzMG55c3h6ZnF2NmoifQ.AGth90CPMwVVSkp93EXmGg'; // For access
            const map = new mapboxgl.Map({ // init a new map and setup for display
                container: 'map',
                style: 'mapbox://styles/mapbox/streets-v11',
                center: data[centervalue].geometry.coordinates,
                zoom: 15
            });

            const outlets = {
                'type': 'FeatureCollection',
                'features': data
            };

                map.on('load', () => { 

                    map.addSource('outlets', {
                        'type': 'geojson',
                        'data': outlets
                    });
                    map.addLayer({
                        'id': 'outlets',
                        'type': 'symbol',
                        'source': 'outlets',
                        
                    });
                    outlets.features.forEach(function(outlet){
                        new mapboxgl.Marker()
                        .setLngLat(outlet.geometry.coordinates)
                        .setPopup(new mapboxgl.Popup({ offset:25 }).setHTML('<h3>' + outlet.properties.title + '</h3>'))
                        .addTo(map);
                    });
                });

                
           
        });
                            
    </script>

    <script>
        function changeRoute(){
            val = document.getElementById("route_id").value;
            console.log(window.recipient, val);
            var url = "{{ route('outlets.changeRoute',['id' => 'route_id', 'to' => 'for']) }}";
            url = url.replace('route_id', window.recipient);
            url = url.replace('for', val);
            console.log(url);

            $.ajax({
                url: url,
                type: 'GET',
                cache: false,
                
                success: function(dataResult){
                    dataResult = JSON.parse(dataResult);
                    if(dataResult.statusCode)
                    {
                        // window.location = "/users";
                        location.reload();
                    }
                    else{
                        console.log(dataResult.statusCode);
                        location.reload();
                    }
                }
            });

        }
    </script>
@endsection
