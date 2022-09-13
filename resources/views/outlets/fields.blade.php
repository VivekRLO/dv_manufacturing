<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('name', 'Owner Name:') !!}
    {!! Form::text('owner_name', null, ['class' => 'form-control']) !!}
</div>


<div class="col-md-6">
    <div class="form-group ">
        <label for="pradesh" class="control-label">
            Province
        </label>
        <select name="province" id="province" class="form-control" onchange=getDistrict(this.value,this.id) required>
            <option selected disabled value="">Select the Province</option>
            @if (isset($provinces))
                @foreach ($provinces as $value)
                <option value="{{ $value }}" 
                    @if (isset($outlet->address)) 
                        @if ($outlet->address->province == $value)
                            selected 
                        @endif
                    @endif
                    >
                    {{ $value }}
                </option>
                @endforeach
            @endif
        </select>
    </div>
</div>
<div class="col-md-6">
    <div class="form-group ">
        <label for="jilla" class="control-label">
            District
        </label>

        <select name="district" id="district" class="form-control" onchange=getMunicipality(this.value,this.id) required>
            <option selected disabled value="">Select the District</option>
            @if (isset($outlet->address))
            <option value="{{ $outlet->address->district }}" selected>
                {{ $outlet->address->district }}
            </option>
            @endif
        </select>
    </div>
</div>
{{-- पालिका --}}
<div class="col-md-6">
    <div class="form-group ">
        <label for="palika" class="control-label">
            Municipality
        </label>
        <select name="address_id" id="palika" class="form-control" required>
            <option selected disabled value="">Select the Municipality</option>
            @if (isset($outlet->address))
            <option value="{{ $outlet->address->id }}" selected>
                {{ $outlet->address->local_level_en }}
            </option>
            @endif
        </select>
    </div>
</div>
{{-- <!-- Street Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('loaction', 'Location:') !!}
    {!! Form::text('street', null, ['class' => 'form-control']) !!}
</div> --}}

<!-- Contact Field -->
<div class="form-group col-sm-6">
    {!! Form::label('contact', 'Contact:') !!}
    {!! Form::text('contact', null, ['class' => 'form-control']) !!}
</div>

{{-- <!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::text('type', null, ['class' => 'form-control']) !!}
</div> --}}

<div class="form-group col-sm-6">
    {!! Form::label('latitude', 'Latitude:') !!}
    {!! Form::text('latitude', null, ['class' => 'form-control']) !!}
</div>

<div class="form-group col-sm-6">
    {!! Form::label('longitude', 'Longitude:') !!}
    {!! Form::text('longitude', null, ['class' => 'form-control']) !!}
</div>
{{-- {!! Form::select('zone',$zones, null, ['class' => 'form-control','onchange'=>'getDistributor(this.value,this.id)']) !!} --}}
<div class="form-group col-sm-6">
    {!! Form::label('zone', 'Zone:') !!}
    <select name="zone_id" id="zone" class="form-control" onclick=getDistributor(this.value,this.id) required>
        <option selected disabled value="">Select the Zone</option>
            @foreach ($zones as $key=>$value)
                <option value="{{ $key }}" 
                    @if (isset($outlet->zones)) 
                        @if ($key === $outlet->zones->id)
                            selected 
                        @endif
                    @endif
                    >
                    {{ $value }}
                </option>
            @endforeach
    </select>
</div>
<div class="form-group col-sm-6">
    {!! Form::label('disrtibutor', 'Distributor:') !!}
    {{-- {!! Form::select('distributor_id',$distributors, null, ['class' => 'form-control']) !!} --}}
    <select name="distributor_id" id="distributor_id" class="form-control" onclick=getroute(this.value,this.id) required>
        <option selected disabled value="">Select the Distributor</option>
        @if (isset($outlet->distributor_id))
        <option selected disabled value="{{ $outlet->distributor_id }}">{{ \App\Models\Distributor::find($outlet->distributor_id)->name }}</option>
        @endif
    </select>
</div>


{{-- {!! Form::text('town_id', null, ['class' => 'form-control']) !!} --}}
<div class="form-group col-sm-6">
    {!! Form::label('town', 'Town:') !!}
    <select name="town_id" id="town_id" class="form-control" required>
        <option selected disabled value="">Select the Town</option>
        @if (isset($outlet->town_id))
        <option selected disabled value="{{ $outlet->town_id??"" }}">{{ \App\Models\Town::find($outlet->town_id)->town??"" }}</option>
        @endif
    </select>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('route', 'Route:') !!}
    {{-- {!! Form::text('route', null, ['class' => 'form-control']) !!} --}}
    <select name="route_id" id="route_id" class="form-control" required>
        <option selected disabled value="">Select the Route</option>
        @if (isset($outlet->route_id)) 
        <option selected disabled value="{{ $outlet->route_id??'' }}">{{ \App\Models\RouteName::find($outlet->route_id)->routename??'' }}</option>
        @endif
    </select>
</div>

<div class="form-group col-sm-6">
    {!! Form::label('channel', 'Channel:') !!}
    @if (isset($channels))
        {!! Form::select('channel_id',$channels, null, ['class' => 'form-control']) !!}
    @endif
</div>

<div class="form-group col-sm-6">
    {!! Form::label('category', 'Category') !!}
    @if (isset($categories))
        {!! Form::select('category_id',$categories, null, ['class' => 'form-control']) !!}
    @endif
</div>

<div class="form-group col-sm-6">
    {!! Form::label('dse', 'DSE') !!}
    @php
        if (isset($outlet->distributor_id)){
            $distributor=\App\Models\Distributor::find($outlet->distributor_id);
        }
    @endphp
    <select name="sales_officer_id" id="sales_officer_id" class="form-control" required>
        <option selected disabled value="">Select the DSE</option>
        @if (isset($distributor))
        @foreach ($distributor->distributor_salesOfficer as $dse)
            <option  @if (isset($outlet->sales_officer_id) && $outlet->sales_officer_id==$dse->id) selected @endif value="{{ $dse->id }}">{{ $dse->name }}</option>
        @endforeach
        @endif
    </select>
</div>

{{-- <div class="form-group col-sm-6">
    {!! Form::label('so', 'Sales Officer') !!}
    {!! Form::text('so', null, ['class' => 'form-control']) !!}
</div>



<div class="form-group col-sm-6">
    {!! Form::label('manager', 'Manager') !!}
    {!! Form::text('manager', null, ['class' => 'form-control']) !!}
</div> --}}

<div class="form-group col-sm-6">
    {!! Form::label('visit_frequency', 'Visit Frequency') !!}
    {!! Form::select('visit_frequency',['Daily'=>'Daily','Weekly'=>'Weekly','Monthly'=>'Monthly','Semi-Yearly'=>'Semi-Yearly','Yearly'=>'Yearly'], null, ['class' => 'form-control']) !!}
</div>


<script type="text/javascript">
    function getDistributor(value) {
        select = document.getElementById('distributor_id');
        select.options.length = 1;
        const url = {!!'"'.url('api/get-distributor?zone_id=').'"'!!} + value;
        $.get(url, function(data, status) {
            for (var i = 0; i < data.data.length; i++) {
                var option = document.createElement("option");
                option.value = data.data[i].id;
                option.text = data.data[i].name;
                if (data.data[i].id == {!!json_encode($outlet->distributor_id??'') !!}) {
                    option.selected = data.data[i].id;
                }
                select.appendChild(option);
            }
        });
        getzone(value);
    }

    function getzone(value) {
        select2 = document.getElementById('town_id');
        select2.options.length = 1;
        const url = {!!'"'.url('api/gettownlist?zone=').'"'!!} + value;
        $.get(url, function(data, status) {
            for (var i = 0; i < data.data.length; i++) {
                var option = document.createElement("option");
                option.value = data.data[i].id;
                option.text = data.data[i].town;
                if (data.data[i].id == {!!json_encode($outlet->town_id??'') !!}) {
                    option.selected = data.data[i].id;
                }
                select2.appendChild(option);
            }
        });
    }

    function getroute(value) {
        select3 = document.getElementById('route_id');
        select3.options.length = 1;
        const url = {!!'"'.url('api/getroutelist?distributor=').'"'!!} + value;
        $.get(url, function(data, status) {
            for (var i = 0; i < data.data.length; i++) {
                var option = document.createElement("option");
                option.value = data.data[i].id;
                option.text = data.data[i].routename;
                if (data.data[i].id == {!!json_encode($outlet->route_id??'') !!}) {
                    option.selected = data.data[i].id;
                }
                select3.appendChild(option);
            }
        });
        getdse(value)
    }
    function getdse(value) {
        select4 = document.getElementById('sales_officer_id');
        select4.options.length = 1;
        const url = {!!'"'.url('api/getdselist?distributor=').'"'!!} + value;
        $.get(url, function(data, status) {
            for (var i = 0; i < data.data.length; i++) {
                var option = document.createElement("option");
                option.value = data.data[i].id;
                option.text = data.data[i].name;
                if (data.data[i].id == {!!json_encode($outlet->sales_officer_id??'') !!}) {
                    option.selected = data.data[i].id;
                }
                select4.appendChild(option);
            }
        });
    }

    function getDistrict(value) {
        select = document.getElementById('district_id');
        select.options.length = 1;
        const url = {!!'"'.url('api/get-address?province_id=').'"'!!} + value;
        $.get(url, function(data, status) {
            for (var i = 0; i < data.length; i++) {
                var option = document.createElement("option");
                option.value = data.data[i].id;
                option.text = data.data[i].name;
                select.appendChild(option);
            }
        });
    }

    function getArea(value) {
        select = document.getElementById('area_id');
        select.options.length = 1;
        const url = {!!'"'.url('api/get-address?district_id=').'"'!!} + value;
        $.get(url, function(data, status) {
            for (var i = 0; i < data.data.length; i++) {
                var option = document.createElement("option");
                option.value = data.data[i].id;
                option.text = data.data[i].name;
                select.appendChild(option);
            }
        });
    }

    function getStreet(value) {
        select = document.getElementById('street_id');
        select.options.length = 1;
        const url = {!!'"'.url('api/get-address?area_id=').'"'!!} + value;
        $.get(url, function(data, status) {
            for (var i = 0; i < data.data.length; i++) {
                var option = document.createElement("option");
                option.value = data.data[i].id;
                option.text = data.data[i].name;
                select.appendChild(option);
            }
        });
    }

</script>

<script type="text/javascript">
    function getDistrict(value, id) {

        let idcount = id.slice(9, 30);
        if (idcount) {
            newid = 'district-' + idcount;
        } else {
            newid = 'district';
        }
        //alert([idcount, newid]);
        select = document.getElementById(newid);
        select.options.length = 1;
        const url = {!!'"'.url('api/addresses?province=').'"'!!} + value;

        $.get(url, function(data, status) {
            // console.log(data);
            for (var i = 0; i < data.length; i++) {
                var option = document.createElement("option");
                option.value = data[i].district;
                option.text = data[i].district;
                // console.log(option.text);
                select.appendChild(option);
            }
        });
        //$('#district').val("");

    }

    function getMunicipality(value, id) {
        let idcount = id.slice(9, 30);
        if (idcount) {
            newid = 'palika-' + idcount;
        } else {
            newid = 'palika';
        }
        // alert([idcount, newid]);

        select = document.getElementById(newid);
        select.options.length = 1;
        const url = {!!'"'.url('api/addresses?district=').'"'!!} + value;
        $.get(url, function(data, status) {
            for (let i = 0; i < data.length; i++) {
                const option = document.createElement("option");
                option.value = data[i].id;
                option.text = data[i].local_level_en;
                // console.log(option.text);
                select.appendChild(option);
            }
        });
    }

</script>
