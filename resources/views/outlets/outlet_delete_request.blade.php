@extends('layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="p-3 row">
            <div class="col-md-12">
                @include('flash::message')

                <div class="card" style="margin-bottom: 0.2rem;">
                    <div class="card-header d-sm-flex align-items-center justify-content-between">
                        <div class="mr-auto">
                            <h3>Outlets Delete Requests</h3>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body row">
                        
                        <div class="table-responsive">
                            <table class="table" id="outlets-table">
                                <thead>
                                    <tr>
                                        <th>SN</th>
                                        <th>Outlet Id</th>
                                        <th>Outlet Name</th>
                                        <th>Requested By</th>
                                        <th>Remark</th>
                                        <th>On</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = 1;
                                    @endphp
                                    @foreach ($data as $request)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td><a href="{{ route('outlets.outlet_filter_by_id', $request->outlet->id??'-') }}">{{ $request->outlet->id??'-' }}</a></td>
                                            <td><a href="{{ route('outlets.outlet_filter_by_id', $request->outlet->id??'-') }}">{{ $request->outlet->name??'-' }}</a></td>
                                            <td><a href="{{ route('users.user_filter', $request->users->id??'-') }}">{{ $request->users->name??'-' }}</a></td>
                                            <td>{{ $request->remark??'-' }}</td>
                                            <td>{{ $request->created_at ?? '' }}</td>
                                            <td>
                                                <div class='btn-group'>
                                                    {!! Form::open(['route' => ['outlets.destroy', $request->outlet->id??'-'], 'method' => 'delete']) !!}
                                                    {!! Form::button('<i class="far fa-trash-alt"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                                <div class='btn-group'>
                                                    {!! Form::open(['route' => ['outlet.outlet_destroy', $request->outlet->id??'-'], 'method' => 'delete']) !!}
                                                    {!! Form::button('<i class="fa fa-ban"></i>', ['type' => 'submit', 'class' => 'btn btn-secondary btn-xs', 'onclick' => "return confirm('Ignore Request?')"]) !!}
                                                    {!! Form::close() !!}
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

