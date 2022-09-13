@extends('layouts.app')

@section('content')
    <style>
        .select2-container .select2-selection--single {
            height: 39px !important;
        }
    </style>
    <div class="content p-3">

        <div class="card" style="margin-bottom: 0.2rem;">
            <div class="card-header d-sm-flex align-items-center justify-content-between">
                <div class="mr-auto">
                    <h3>Check In Outs</h3>
                </div>
            </div>
        </div>

        {!! Form::open(['route' => 'checkInOut.search', 'method' => 'get']) !!}
        <div class="card">
            <div class="card-body row">

                <div class="form-group col-sm-2">
                    {!! Form::label('salesOfficer_id', 'Sales Officer:') !!}
                    {!! Form::select('salesOfficer_id', $salesOfficer, null, ['class' => 'form-control search-dropdown-salesofficer']) !!}
                </div>

                <div class="form-group col-sm-2">
                    {!! Form::label('date_from', 'Date From:') !!}
                    {!! Form::text('date_from', null, ['class' => 'form-control', 'id' => 'date_from']) !!}
                </div>

                <div class="form-group col-sm-2">
                    {!! Form::label('date_to', 'Date To:') !!}
                    {!! Form::text('date_to', null, ['class' => 'form-control', 'id' => 'date_to']) !!}
                </div>

                <div class="form-group col-sm-4" style="padding-top: 28px;">
                    {!! Form::submit('Search', ['class' => 'btn btn-primary']) !!}
                </div>

            </div>
        </div>
        {!! Form::close() !!}

        @include('flash::message')

        <div class="card">
            <div class="card-body row">
                @include('check_in_outs.table')

                <div class="card-footer clearfix float-right">
                    <div class="float-right">
                        @include('adminlte-templates::common.paginate', ['records' => $checkInOuts])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('third_party_scripts')
    <script type="text/javascript">
        $('#date_from').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        });
        $('#date_to').datetimepicker({
            format: 'YYYY-MM-DD',
            useCurrent: true,
            sideBySide: true
        });
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            $(".search-dropdown-salesofficer").select2();
        });
    </script>
@endsection
