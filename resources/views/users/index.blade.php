@extends('layouts.app')

@section('content')
    <div class="content p-3">

        @include('flash::message')

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Users</h3>
                </div>
                @if (Auth::user()->role == 0)
                    <a class="btn btn-primary"
                        href="{{ route('user.create') }}">
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
                    <form action="{{ route('users.user_filter_by_flag') }}" method="post">
                        @csrf
                        <li class="user-header" style="text-align: left!important; ">
                            <div class="row" >
                                <div class="form-group col-sm-12">
                                    {!! Form::label('flagname', 'Flag:') !!}
                                    <select name="flag" id="flag" class="form-control">
                                        <option value="0" selected>Active</option>
                                        <option value="1">Inactive</option>
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
            <div class="card-body">
                <div class="row">
                    @include('users.table')
                </div>
            </div>
        </div>
    </div>

@endsection

