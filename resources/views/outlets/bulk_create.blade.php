@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>Bulk Outlets Entry</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">
            {{-- <form action="{{ route('file-import') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group mb-4" style="max-width: 500px; margin: 0 auto;">
                    <div class="custom-file text-left">
                        <input type="file" name="file" class="custom-file-input" id="customFile">
                        <label class="custom-file-label" for="customFile">Choose file</label>
                    </div>
                </div>
                <button class="btn btn-primary">Import data</button>
                <a href="{{ route('products.index') }}" class="btn btn-default">Cancel</a>
            </form> --}}
            {!! Form::open(['route' => 'file-import-outlets', 'method' => 'POST', 'files' => 'true', 'enctype' => 'multipart/form-data']) !!}
            @csrf
            <div class="card-body">
                <div class="form-group col-sm-6">
                    {!! Form::label('outletsExcel', 'Import file of Product Detail List:') !!}
                    <div class="input-group">
                        <div class="custom-file">
                            {!! Form::file('outletsExcel', ['class' => 'custom-file-input']) !!}
                            {!! Form::label('outletsExcel', 'Choose Excel/CSV File', ['class' => 'custom-file-label', 'required' => 'required']) !!}
                        </div>
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    Note:<a href="{{ asset('public/sample_outlet.xlsx') }}" class="btn btn-link">Click here to Download sample excel file.</a>
                </div>
            </div>

            
            <div class="card-footer">
                {!! Form::submit('Import data', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('products.index') }}" class="btn btn-default">Cancel</a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
