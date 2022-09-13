<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Carbon\Carbon;
use App\Models\User;
use App\Models\CheckInOut;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Models\DailyLocation;
use Illuminate\Support\Facades\Auth;
use App\Repositories\CheckInOutRepository;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\CreateCheckInOutRequest;
use App\Http\Requests\UpdateCheckInOutRequest;

class CheckInOutController extends AppBaseController
{
    /** @var  CheckInOutRepository */
    private $checkInOutRepository;

    public function __construct(CheckInOutRepository $checkInOutRepo)
    {
        $this->checkInOutRepository = $checkInOutRepo;
    }

    /**
     * Display a listing of the CheckInOut.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = [];
        if (Auth::user()->type == 1) {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $users =User::where('type',1)->where('regionalmanager',Auth::user()->id)->where('role',5)->pluck('id');
            }
            //Admin
            else {
                $users =User::where('type',1)->whereIn('role',[4,5])->pluck('id');
            }
            //Trading
        } else {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $users =User::where('type',2)->where('regionalmanager',Auth::user()->id)->where('role',5)->pluck('id');
            }
            //Admin
            else {
                $users =User::where('type',2)->whereIn('role',[4,5])->pluck('id');
            }
        } 
        $checkInOuts = CheckInOut::whereIn('sales_officer_id',$users)->orderBy('checkin_device_time', 'DESC')->paginate(100);
        $salesOfficer = User::whereIn('id',$users)->pluck('name', 'id');
        $salesOfficer->prepend('None', 0);
        return view('check_in_outs.index', compact('salesOfficer'))
            ->with('checkInOuts', $checkInOuts);
    }

    /**
     * Show the form for creating a new CheckInOut.
     *
     * @return Response
     */
    public function create()
    {
        return view('check_in_outs.create');
    }

    /**
     * Store a newly created CheckInOut in storage.
     *
     * @param CreateCheckInOutRequest $request
     *
     * @return Response
     */
    public function store(CreateCheckInOutRequest $request)
    {
        $input = $request->all();

        $checkInOut = $this->checkInOutRepository->create($input);

        Flash::success('Check In Out saved successfully.');

        return redirect(route('checkInOuts.index'));
    }

    /**
     * Display the specified CheckInOut.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $checkInOut = $this->checkInOutRepository->find($id);

        if (empty($checkInOut)) {
            Flash::error('Check In Out not found');

            return redirect(route('checkInOuts.index'));
        }

        return view('check_in_outs.show')->with('checkInOut', $checkInOut);
    }

    /**
     * Show the form for editing the specified CheckInOut.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $checkInOut = $this->checkInOutRepository->find($id);

        if (empty($checkInOut)) {
            Flash::error('Check In Out not found');

            return redirect(route('checkInOuts.index'));
        }

        return view('check_in_outs.edit')->with('checkInOut', $checkInOut);
    }

    /**
     * Update the specified CheckInOut in storage.
     *
     * @param int $id
     * @param UpdateCheckInOutRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCheckInOutRequest $request)
    {
        $checkInOut = $this->checkInOutRepository->find($id);

        if (empty($checkInOut)) {
            Flash::error('Check In Out not found');

            return redirect(route('checkInOuts.index'));
        }

        $checkInOut = $this->checkInOutRepository->update($request->all(), $id);

        Flash::success('Check In Out updated successfully.');

        return redirect(route('checkInOuts.index'));
    }

    /**
     * Remove the specified CheckInOut from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $checkInOut = $this->checkInOutRepository->find($id);

        if (empty($checkInOut)) {
            Flash::error('Check In Out not found');

            return redirect(route('checkInOuts.index'));
        }

        $this->checkInOutRepository->delete($id);

        Flash::success('Check In Out deleted successfully.');

        return redirect(route('checkInOuts.index'));
    }

    public function search(Request $request)
    {
        if ($request->salesOfficer_id >= 1) {
            if ($request->date_from) {
                $checkInOuts = CheckInOut::where('sales_Officer_id', $request->salesOfficer_id)->whereBetween('checkin_device_time', [$request->date_from . ' 00:00:00', $request->date_to . ' 23:59:59' ?? Carbon::now()])->orderBy('checkin_device_time', 'DESC')->paginate(100);
            } else {
                $checkInOuts = CheckInOut::where('sales_Officer_id', $request->salesOfficer_id)->orderBy('checkin_device_time', 'DESC')->paginate(100);
            }
        } elseif (($request->salesOfficer_id == 0) && empty($request->date_from) && empty($request->date_to)) {
            $checkInOuts = CheckInOut::orderBy('checkin_device_time', 'DESC')->paginate(100);
        } else {
            $checkInOuts = CheckInOut::whereBetween('checkin_device_time', [$request->date_from . ' 00:00:00', $request->date_to . ' 23:59:59' ?? Carbon::now()])->orderBy('checkin_device_time', 'DESC')->paginate(100);
        }
        $salesOfficer = User::where('role', 5)->pluck('name', 'id');
        $salesOfficer->prepend('Select Sale Officer', 0);
        return view('check_in_outs.index', compact('salesOfficer'))
            ->with('checkInOuts', $checkInOuts);
    }
    public function map_report($id)
    {
        $checkinout = CheckInOut::find($id);
        // dd($checkinout);
        $location_logs = DailyLocation::where('checkinout_id', $id)->orderby('date')->get();
        //  dd(sizeOf($location_logs));
        $positions = [];
        $checkout = "false";
        if (isset($location_logs)) {
            for ($i = 0; $i < sizeOf($location_logs); $i++) {

                $positions[$i][0] = (double) $location_logs[$i]->longitude;
                $positions[$i][1] = (double) $location_logs[$i]->latitude;
            }
            // dd($i);
            if (isset($checkinout->checkout_device_time)) {
                // dd('data');
                $checkout = "true";
                $positions[$i][0] = (double) $checkinout->checkout_longitude;
                $positions[$i][1] = (double) $checkinout->checkout_latitude;
            }

        }
        $positions = Arr::prepend($positions, [(double) $checkinout->checkin_longitude, (double) $checkinout->checkin_latitude]);
        // $temp=array_add($temp,[(double)$checkinout->checkout_longitude,(double)$checkinout->checkout_latitude ]);
        // dd($temp);
        $temp_sale = [];
        $sales = DailyLocation::where('checkinout_id', $id)->whereNotNull('outlet_id')->get();
        if (isset($sales)) {
            for ($i = 0; $i < sizeOf($sales); $i++) {

                $temp_sale[$i][0] = (double) $sales[$i]->longitude;
                $temp_sale[$i][1] = (double) $sales[$i]->latitude;
            }
        }
        //  dd($checkout);
        return view('check_in_outs.map_report', compact('positions', 'checkinout', 'temp_sale', 'checkout'));
    }
    public function test_report($id)
    {
        $checkinout = CheckInOut::find($id);
        // dd($checkinout);
        $location_logs = DailyLocation::where('checkinout_id', $id)->orderby('date')->get();
        //  dd(sizeOf($location_logs));
        $positions = [];
        if (isset($location_logs)) {
            for ($i = 0; $i < sizeOf($location_logs); $i++) {

                $positions[$i][0] = (double) $location_logs[$i]->longitude;
                $positions[$i][1] = (double) $location_logs[$i]->latitude;
            }
            // dd($i);
            if (isset($checkinout->checkout_device_time)) {
                dd('data');
                $positions[$i][0] = (double) $checkinout->checkout_longitude;
                $positions[$i][1] = (double) $checkinout->checkout_latitude;
            }

        }
        $positions = Arr::prepend($positions, [(double) $checkinout->checkin_longitude, (double) $checkinout->checkin_latitude]);
        // $temp=array_add($temp,[(double)$checkinout->checkout_longitude,(double)$checkinout->checkout_latitude ]);
        // dd($temp);
        $temp_sale = [];
        $sales = DailyLocation::where('checkinout_id', $id)->whereNotNull('outlet_id')->get();
        if (isset($sales)) {
            for ($i = 0; $i < sizeOf($sales); $i++) {

                $temp_sale[$i][0] = (double) $sales[$i]->longitude;
                $temp_sale[$i][1] = (double) $sales[$i]->latitude;
            }
        }
        // dd($temp_sale);
        return view('check_in_outs.test_report', compact('positions', 'checkinout', 'temp_sale'));
    }
    public function live_location()
    {
        $users = [];
        if (Auth::user()->type == 1) {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $users =User::where('type',1)->where('regionalmanager',Auth::user()->id)->where('role',5)->pluck('id');
            }
            //Admin
            else {
                $users =User::where('type',1)->whereIn('role',[4,5])->pluck('id');
            }
            //Trading
        } else {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $users =User::where('type',2)->where('regionalmanager',Auth::user()->id)->where('role',5)->pluck('id');
            }
            //Admin
            else {
                $users =User::where('type',2)->whereIn('role',[4,5])->pluck('id');
            }
        } 
        $today = Carbon::now()->format('Y-m-d');
        $checkInOut = CheckInOut::whereIn('sales_officer_id',$users)->where('checkin_device_time', 'like', '%' . $today . '%')->with('location')->get();
        $data = [];


        // dd($checkInOut[0]->location);
        for ($i = 0; $i < sizeOf($checkInOut); $i++) {
            $item=[];
            if ($checkInOut[$i]->checkout_device_time == null) {
                if ($checkInOut[$i]->location != null) {
                    $item['type'] = 'Feature';
                    $item['properties']['description'] = $checkInOut[$i]->salesOfficer->name;
                    $item['geometry']['type'] = 'Point';
                    $item['geometry']['coordinates'] = [$checkInOut[$i]->location->longitude, $checkInOut[$i]->location->latitude];
                } else {
                    $item['type'] = 'Feature';
                    $item['properties']['description'] = $checkInOut[$i]->salesOfficer->name;
                    $item['geometry']['type'] = 'Point';
                    $item['geometry']['coordinates'] = [$checkInOut[$i]->checkin_longitude, $checkInOut[$i]->checkin_latitude];
                }
            }
             
            $data[$i]=$item;
        }
        return view('check_in_outs.livelocation', compact('today', 'data'));

    }
}
