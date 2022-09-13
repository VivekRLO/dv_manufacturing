@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Monthly Tour Details</h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right" href="{{ route('monthlyTours.index') }}">
                        Back
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">

            <div class="card-body">
                <div class="row">
                    @include('monthly_tours.show_fields')

                </div>
                <div class="table-responsive">
                    <table class="table" id="monthlyTours-table">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Day</th>
                                <th>Town/Stockist</th>
                                <th>Route/Market</th>
                                <th>Night Halt</th>
                                <th>Contact Address</th>
                                <th>Stockist Phone No.</th>
                                <th>Hotel Phone No.</th>

                            </tr>
                        </thead>
                        <tbody>
                           
                            @foreach (json_decode($monthlyTour->data,true) as $data)
                              <tr>
                                <td>{{$data['date']}}</td>
                                <td>{{$data['day']}}</td>
                                <td>{{$data['town']}}</td>
                                <td>{{$data['route']}}</td>
                                <td>{{$data['nightHalt']}}</td>
                                <td>{{$data['contactAddress']}}</td>
                                <td>{{$data['stocklistPhone']}}</td>
                                <td>{{$data['hotelPhone']}}</td>
                                 
                              </tr>
                          @endforeach

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@endsection
