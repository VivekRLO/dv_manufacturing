@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <h3>Profile</h3>
        @include('flash::message')

        <div class="clearfix"></div>
        <div class="col-md-12">

            <form action="{{ route('upload_photo') }}" enctype="multipart/form-data" method="post" autocomplete="off">
                @csrf
                <div class="card-header">Photo</div>
                <div class="card-body row">
                    <div class="col-md-3">
                        @if (empty( Auth::user()->photo))
                        <img src="https://assets.infyom.com/logo/blue_logo_150x150.png" width="200" height="200"
                            class="brand-image img-circle elevation-3">
                        @else
                        <img src="{{asset('storage/'. $user->photo)  }}" width="200"
                            height="200" class="brand-image img-circle elevation-3">
                        @endif
                    </div>

                    <div class="col-md-6" style="margin-top:80px">
                        Choose an image from your device
                        <input type="file" name="profile_photo" class="form-control" required>
                        <input type="submit" class="btn btn-primary" name="submit" value="Upload">
                        <a class="btn btn-secondary" href="">Cancel</a>
                    </div>
                </div>
            </form>
            <form action="{{ route('update_profile') }}" enctype="multipart/form-data" method="post" autocomplete="off">
                @csrf
                <div class="content px-3">
                    <div class="card-header">Information</div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-sm-6">
                                <label for="name" class="">Full Name</label>
                                <input type="text" class="form-control" name="name"
                                    value="{{ $user->name ?? old('name') }}" required>
                            </div>
                            
                            <div class="form-group col-sm-6">
                                <label for="email" class="">User Email</label>
                                <input type="email" class="form-control" name="email"
                                    value="{{ $user->email ?? old('email') }}" required>
                            </div>
                            <div class="form-group col-sm-6">
                                <label for="phone" class="">Phone Number:</label>
                                <input type="number" class="form-control" name="phone"
                                    value="{{ $user->phone ?? old('phone') }}" >
                            </div>
                          

                        </div>
                        <div class="row">
                            To change Password &nbsp;
                            <a href="{{ route('get_change_password') }}" class="link "> Click here.</a>
                        </div>
                        <hr>
                        <input type="submit" class="btn btn-primary" name="submit" value="Update">
                        <a href="{{route('home')}}" class="btn btn-secondary">Cancel</a>
                    </div>
                </div>
            </form>

        </div>

    </div>

</div>
@endsection