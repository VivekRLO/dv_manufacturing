@extends('layouts.app')

@section('content')

    <div class="content p-3">

        @include('flash::message')

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Outlets</h3>
                </div>
                @if (Auth::user()->role == 0)
                    <a class="btn btn-primary mr-2" 
                        href="{{ route('outlets.bulk_create') }}">
                        Bulk Add
                    </a>

                    <a class="btn btn-primary"
                        href="{{ route('outlets.create') }}">
                        Add New
                    </a>
                @endif
            </div>
        </div>

        {{-- Filter Option Start --}}

        <ul class="navbar-nav ml-auto mb-1">
            <li class="nav-item dropdown user-menu">
                <a href="#" class="btn btn-primary nav-link dropdown-toggle" style="width: 135px" data-toggle="dropdown">
                    <i class="fa fa-filter" aria-hidden="true">Filter Option</i>
                </a>
                <ul class="dropdown-menu dropdown-menu-left" style="width: 25% !important; padding:5px">
                    <form action="{{ route('outlet.outlet_filter') }}" method="POST">
                        @csrf
                        <li class="user-header" style="text-align: left!important; ">
                            <div class="row" >
                                <div class="form-group col-sm-12">
                                    {{-- For route name --}}
                                    <input name="route_id" value="{{ $route_id }}" hidden> 
                                    {!! Form::label('town', 'Towns:') !!}
                                    {{-- {!! Form::select('name',[], null, ['class' => 'form-control','id'=>'filtername']) !!} --}}
                                    <select name="town_id" id="filtername" class="form-control">
                                        <option value="" disabled selected>Choose Option</option>
                                        @foreach ($towns as $town)
                                            <option value="{{ $town->id }}">{{ $town->town }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="form-group col-sm-12">
                                    {!! Form::label('channel', 'Channels:') !!}
                                    {{-- {!! Form::select('name',[], null, ['class' => 'form-control','id'=>'filtername']) !!} --}}
                                    <select name="channel_id" id="filtername" class="form-control">
                                        <option value="" disabled selected>Choose Option</option>
                                        @foreach ($channels as $channel)
                                            <option value="{{ $channel->id }}">{{ $channel->channel }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group col-sm-12">
                                    {!! Form::label('dse', 'DSE:') !!}
                                    <select name="dse_id" id="filtername" class="form-control">
                                        <option value="" disabled selected>Choose Option</option>
                                        @foreach ($dses as $dse)
                                            <option value="{{ $dse->id }}">{{ $dse->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                    
                            <button type="submit" class="btn btn-success"><i class="fa fa-filter" aria-hidden="true">Filter</i> </button> 
                      
                    </form>
                </ul>
            </li>
        </ul>

        {{-- Filter option END --}}

        <div class="card">
            <div class="card-body row">
                @include('outlets.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $outlets])
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

