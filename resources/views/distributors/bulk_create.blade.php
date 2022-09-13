@extends('layouts.app')

@section('content')

    <div class="content p-3">

        @include('adminlte-templates::common.errors')

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Bulk Distributors Entry</h3>
                </div>
            </div>
        </div>

        <div class="card">
            {!! Form::open(['route' => 'distributors.file-import', 'method' => 'POST', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
            @csrf
            <div class="card-body">
                <div class="form-group col-sm-6">
                    {!! Form::label('distributorExcel', "Import file of Distributors' Detail List:") !!}
                    <div class="input-group">
                        <div class="custom-file">
                            {!! Form::file('distributorExcel', ['class' => 'custom-file-input']) !!}
                            {!! Form::label('distributorExcel', 'Choose Excel/CSV File', ['class' => 'custom-file-label', 'required' => 'required']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    Note:<a href="{{ asset('public/DistributorSampleExcel.xlsx') }}" class="btn btn-link">Click here to Download sample excel file.</a>
                </div>
            </div>

            
            <div class="card-footer">
                {!! Form::submit('Import data', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('distributors.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
