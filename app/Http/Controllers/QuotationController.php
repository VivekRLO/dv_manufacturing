<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use App\Models\Quotation;
use App\Models\User;

use Flash;
use Carbon\Carbon;

class QuotationController extends Controller
{
    public function index()
    {
        
        $quotations = Quotation::with('users')->get()->groupBy('month');
        foreach ($quotations as $key => $quotation) {
            
            // dd( $key, $quotation[0]->value);
        }

        return view('quotations.index')->with('quotations', $quotations);
    }

    public function create()
    {
        if(Auth::user()->role == 4){
            $users = User::where('role', 5)->where('flag', 0)->where('regionalmanager', Auth::user()->id)->pluck('name', 'id');
        }else{
            $users = User::where('role', 5)->where('flag', 0)->pluck('name', 'id');
        }
        return view('quotations.create', [
            'users' => $users,
        ]);
    }

    public function edit($id)
    {
        $quotation = Quotation::where('id', $id)->first();
        $user = User::where('role', 5)->where('flag', 0);
        if(Auth::user()->role == 4){
            $users = $user->where('regionalmanager', Auth::user()->id)->pluck('name', 'id');
        }else{
            $users = $user->pluck('name', 'id');
        }

        return view('quotations.edit', compact('users', 'quotation'));

    }

    public function store(Request $request)
    {

        Quotation::create($request->all());
        Flash::success('Quotation Created SuccessFully.');

        return redirect()->route('quotation.index');

    }

    public function update($id, Request $request)
    {

        Quotation::where('id', $id)->update([
            'user_id' => $request->user_id,
            'value' => $request->value,
            'month' => $request->month,
        ]);
        Flash::success('Quotation Updated SuccessFully.');

        return redirect(route('quotation.index'));
    }

    public function destroy($id)
    {

        $quotation = Quotation::find($id)->delete();

        if($quotation){
            Flash::success('Quotation Deleted SuccessFully.');
        }else{
            Flash::error('Something went wrong');
        }
        return redirect(route('quotation.index'));

    }

    public function dse_view($date)
    {
        // dd($date, Carbon::now()->format('M-Y'));
        $quotations = Quotation::where('month', $date)->with('users')->get();

        return view('quotations.dse_view', compact('quotations'));
    }


}
