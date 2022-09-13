<?php

namespace App\Http\Controllers;

use App\Models\User;
use Laracasts\Flash\Flash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ProfileController extends Controller
{
    //
    public function get_profile()
    {
        $user = User::find(Auth::user()->id);
        return view('auth.profile')
            ->with('user', $user);
    }
    public function upload_photo(Request $request)
    {
        $user = Auth::user();

        if ($request->hasFile('profile_photo')) {
            $file = $request->file('profile_photo');
            $extension = $request->file('profile_photo')->getClientOriginalExtension();
            $fileNameWithExt = $request->file('profile_photo')->getClientOriginalName();
            $filename_temp = preg_replace('/[^a-zA-Z0-9_-]+/', '', pathinfo($fileNameWithExt, PATHINFO_FILENAME));
            $filename = $filename_temp . '_' . time() . '.' . $extension;
            $photo = 'user_profile/' . $filename;
            $file->storeAs('user_profile', $filename, 'public');
            $user->photo = $photo;
            $user->save();
            Flash::success('Profile Picture Update SuccessFully.');
            return redirect()->back();
        }

    }

    public function update_profile(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|',

        ]);
        // if ($validator->fails()) {
        //     Flash::error('Email/Phonenumber already in used, Please try again with another Email/PhoneNumber.');
        //     return redirect()->back();
        // }
        $oldphone = User::where('phone', $request->phone)->first();
        $oldemail = User::where('email', $request->email)->first();

        $user = User::find(Auth::user()->id);
        $user->name = $request->name;
        $user->email=$request->email;
        if (empty($oldphone)) {
            $user->phone = $request->phone;
            Flash::success('Profile Information Update Successfully');
        }else{
            Flash::success("Profile Information Update Successfully, Phonenumber Cannot Update. It's already in used.");
        }
        
        $user->save();
        // return view('auth.profile')->with('user', $user);
        return redirect(route('get_profile'));
    }

    public function get_change_password()
    {
        return view('auth.newpassword');
    }
    public function post_change_password(Request $request)
    {
        if (Hash::check($request->current_password, Auth::user()->password)) {
            $request->validate([
                'current_password' => ['required'],
                'new_password' => ['required'],
                'new_confirm_password' => ['same:new_password'],
            ]);

            User::find(Auth::user()->id)->update(['password' => Hash::make($request->new_password)]);
            $user = User::find(Auth::user()->id)->first();

            Flash::success('Password Change Successfully');

            return view('auth.profile')->with('user', $user);
        }
    }
}
