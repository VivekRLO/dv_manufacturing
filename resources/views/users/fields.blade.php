<!-- type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {{-- {!! Form::select('type', ['' => 'Select type', 1 => 'Manufacturer', 2 => 'Trading'], null, ['class' => 'form-control', 'required' => 'required']) !!} --}}
 <select name="type" id="" class="form-control" readonly>
    @if (Auth::user()->type==1)
    <option value="1" selected >Manufacturer</option> 
@else
<option value="2" selected>Trading</option>
@endif
     
 </select>
   
</div>

<!-- Role Field -->
<div class="form-group col-sm-6">
    {!! Form::label('role', 'Role:') !!}
    {!! Form::select('role', ['' => 'Select Role', 4 => 'Regional Manager',3=>'Sales Officer', 5 => 'DSE',6 => 'Distributor'], null, ['class' => 'form-control', 'required' => 'required', 'onchange' => 'getRegionalManager(this.value)']) !!}
</div>

<!-- RegionalManager Field -->
<div class="form-group col-sm-6" style="display:none" id="RegionalManager">
    {!! Form::label('RegionalManager', 'Regional Manager:') !!}
    <select class=" form-control" id="regionalmanager" name="regionalmanager" onchange="getSalesSupervisor(value)" value="{{ old('regionalmanager') }}">
        <option selected disabled value="">Select the Regional Manager</option>
        @foreach (\app\Models\User::where('role', 4)->get() as $item)
            <option value="{{ $item->id }}">{{ $item->name }}</option>
        @endforeach
    </select>
</div>

<!-- supervisor_sales_officer Field -->
<div class="form-group col-sm-6" style="display:none" id="supervisor_sales_officer">
    {!! Form::label('supervisor_sales_officer', 'Sales Supervisor:') !!}
    <select class=" form-control" id="supervisor_sales_officer_id" name="sales_supervisor_id" value="{{ old('sales_supervisor_id') }}">
        <option selected disabled value="">Select the Sales Supervisor</option>
    </select>
</div>


<!-- Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('name', 'Full Name:') !!}
    {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'requird']) !!}
</div>

<!-- Phone Field -->
<div class="form-group col-sm-6">
    {!! Form::label('phone', 'Phone:') !!}
    {!! Form::number('phone', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>

<!-- Email Field -->
<div class="form-group col-sm-6">
    {!! Form::label('email', 'Email:') !!}
    {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required']) !!}
</div>



@if(Auth::user()->role==0)
    <!-- Flag Field -->
    <div class="form-group col-sm-6" id ="flag" >
        {!! Form::label('flag', 'Status:') !!}
        <select name="flag" id="flag" class="form-control">
            <option value="0" @if (isset($user)) @if ($user->flag == 0) selected @endif @endif>Active</option>
            <option value="1"  @if (isset($user)) @if ($user->flag == 1) selected @endif @endif>Inactive</option>
        </select>
    </div>
    <!-- Password Field -->
    <div class="form-group col-sm-6" id ="password" style="display:block" >
        {!! Form::label('password', 'Change Password:') !!}
        {{-- {!! Form::text('password', null,['class' => 'form-control','required'=>'required']) !!} --}}
        <input type="password" class="form-control" name="password" >
    </div>
@endif

<script type="text/javascript">
    function getRegionalManager(value) {
        if (value == 5) {
            document.getElementById("RegionalManager").style.display = "block";
            document.getElementById("supervisor_sales_officer").style.display = "block";
            document.getElementById("password").style.display = "none";
        } else if(value == 3) {
            document.getElementById("RegionalManager").style.display = "block";
            document.getElementById("supervisor_sales_officer").style.display = "none";
            document.getElementById("password").style.display = "none";
        }else {
            document.getElementById("RegionalManager").style.display = "none";
            document.getElementById("supervisor_sales_officer").style.display = "none";
            document.getElementById("password").style.display = "block";
        }

    }

    function getMarketingDirector(value) {
        select = document.getElementById('marketing_director_id');
        select.options.length = 1;
        const url = {!! '"' . url('api/get-data?admin_id=') . '"' !!} + value;
        $.get(url, function(data, status) {
            for (var i = 0; i < data.data.length; i++) {
                var option = document.createElement("option");
                option.value = data.data[i].id;
                option.text = data.data[i].name;
                select.appendChild(option);
            }
        });
    }

    function getMarketingManager(value) {
        selectBranch = document.getElementById('marketing_manager_id');
        selectBranch.options.length = 1;
        const url = {!! '"' . url('api/get-data?marketing_director_id=') . '"' !!} + value;
        $.get(url, function(data, status) {
            for (var i = 0; i < data.data.length; i++) {
                var option = document.createElement("option");
                option.value = data.data[i].id;
                option.text = data.data[i].name;
                selectBranch.appendChild(option);
            }
        });
    }

    function getSalesSupervisor(value) {
        selectBranch = document.getElementById('supervisor_sales_officer_id');
        selectBranch.options.length = 1;
        const url = {!! '"' . url('api/get-data?regionalmanager=') . '"' !!} + value;
        $.get(url, function(data, status) {
            for (var i = 0; i < data.data.length; i++) {
                var option = document.createElement("option");
                option.value = data.data[i].id;
                option.text = data.data[i].name;
                selectBranch.appendChild(option);
            }
        });
    }

</script>
