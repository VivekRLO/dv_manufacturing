@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Location List</h1>
                </div>
                
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table" id="locations-table">
                        <thead>
                            <tr>
                                <th>Provinces</th>
                                <th>Districts</th>
                                <th>Municipality</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($locations as $location)
                            <tr>
                                <td>{{ $location->province }}</td>
                                <td>{{ $location->district }}</td>
                                <td>{{ $location->local_level_en }}</td>
                               
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $locations])
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

