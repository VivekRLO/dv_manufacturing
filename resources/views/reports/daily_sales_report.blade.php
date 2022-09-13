@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>DAILY SUMMARY SALES REPORT OF ALL DSE</h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')
        <form action="{{ route('report.day_wise_report') }}" method="POST">
            @csrf
            <div class="row">
                <div class="form-group col-sm-4">
                    {!! Form::label('date', 'Select Date:') !!}
                    {!! Form::text('date', null, ['class' => 'form-control', 'id' => 'date' ,'required'=>'required']) !!}
                </div>
                @push('page_scripts')
                    <script type="text/javascript">
                        $('#date').datetimepicker({
                            format: 'YYYY-MM-DD',
                            sideBySide: true,
                        })
                    </script>
                @endpush
                <div style=" padding-top: 25px;">
                    <button type="submit" class="btn btn-lg btn-default">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>

        </form>
        @if (isset($date))
            <div class="row">
                <h4>Date:{{ $date }}</h4>
            </div>

        @endif

        <div class="clearfix"></div>
        @if (isset($datas))
            <div class="card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        {{-- <table  id="sales-table" class="display nowrap" style="width:100%"> --}}
                        <table class="table" id="report-table">
                            <thead>
                                <tr>
                                    <th>DSE</th>
                                    @foreach ($products as $product)
                                        <th>{{ $product }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    foreach ($datas as $key => $data) {
                                        $temp = [];
                                        echo ' <tr>';
                                        echo '<td>' . App\Models\User::find($key)->name . '</td>';
                                        foreach ($data as $item) {
                                          $temp[$item->product_id]=$item->sum;
                                        }
                                        foreach ($products as $key =>$product) {
                                            if(isset($temp[$key])){
                                                echo '<td>'.$temp[$key].'</td>';
                                            }else{
                                                echo '<td>-</td>';

                                            }
                                        }
                                       
                                        
                                        echo '</tr>';
                                    }
                                @endphp
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
    </div>
    @endif
@endsection
