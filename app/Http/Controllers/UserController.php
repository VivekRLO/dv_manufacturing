<?php

namespace App\Http\Controllers;

use Response;
use App\Models\User;
use App\Models\SalesOfficer;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\AppBaseController;
use App\Models\Distributor;
use App\Models\Outlet;
use App\Models\RouteLog;
use App\Models\RouteName;
use App\Models\Sale;
use App\Models\DayWiseRouteSetup;
use App\Models\Quotation;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Laracasts\Flash\Flash;
use Illuminate\Support\Facades\DB;


use Illuminate\Support\Str;


class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        //Manufacturer
        if (Auth::user()->type == 1) {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $users = User::where('type', 1)->where('regionalmanager', Auth::user()->id)->whereIn('role',[3,5])->where('flag',0)->get();
            }
            //Admin
            else {
                $users = User::where('type', 1)->whereIn('role', [3, 4, 5])->where('flag',0)->get();
            }
            //Trading
        } else {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $users = User::where('type', 2)->where('regionalmanager', Auth::user()->id)->whereIn('role',[3,5])->where('flag',0)->get();

            }
            //Admin
            else {
                $users = User::where('type', 2)->whereIn('role',[3, 4, 5, 6])->where('flag',0)->with('distributors')->get();
            }
        }
        // dd($users);

        return view('users.index')
            ->with('users', $users);
    }

    /**
     * Show the form for creating a new User.
     *
     * @return Response
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(CreateUserRequest $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|unique:users',

        ]);
        if ($validator->fails()) {
            Flash::error('Email/Phonenumber already in used, Please try again with another Email/PhoneNumber.');
            return view('users.create');
        }

        // $input = $request->all();
        // dd($request->password);
        $input['type'] = $request->type;
        $input['role'] = $request->role;
        $input['name'] = $request->name;
        $input['phone'] = $request->phone;
        $input['email'] = $request->email;
        $input['password'] = Hash::make($request->password);

        if ($input['role'] == 5) {
            $input['sales_supervisor_id'] = $request->sales_supervisor_id;
            $input['regionalmanager'] = $request->regionalmanager;
        }elseif($input['role']==3){
            $input['regionalmanager'] = $request->regionalmanager;
        }
        // dd($input);
        $user = $this->userRepository->create($input);
       if($request->role=="6"){
           $data['name']= $request->name;
           $data['contact']= $request->phone;
           $data['email']= $request->email;
           $data['userid']= $user->id;
           $data['manufacturer_trading_type']= '2';
           Distributor::create($data);
       }

        Flash::success('User saved successfully.');

        return redirect(route('user.index'));
    }

    /**
     * Display the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $user = User::where('id', $id)->with('route_users')->first();

        if($user->role != 5){
            $users = User::where('regionalmanager', $id)->orwhere('sales_supervisor_id', $id)->with('route_users')->get();
        }else{
            $users = [];
        }

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('user.index'));
        }
        // dd($user);
        return view('users.show', compact('users'))->with('user', $user);
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('user.index'));
        }

        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified User in storage.
     *
     * @param int $id
     * @param UpdateUserRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateUserRequest $request)
    {
        // dd($id);  
        $user = $this->userRepository->find($id);
        $input['type'] = $request->type;
        $input['role'] = $request->role;
        $input['name'] = $request->name;
        $input['phone'] = $request->phone;
        $input['email'] = $request->email;
        $input['flag'] = $request->flag;
        $input['password'] = Hash::make($request->password);

        if ($input['role'] == 5) {
            $input['regionalmanager'] = $request->regionalmanager;
        }
        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('user.index'));
        }

        $user = $this->userRepository->update($input, $id);

        Flash::success('User updated successfully.');

        return redirect(route('user.index'));
    }

    /**
     * Remove the specified User from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('user.index'));
        }
        $input['flag'] = 1;
        $this->userRepository->update($input, $id);

        Flash::success('User deleted successfully.');

        return redirect(route('user.index'));
    }

    public function dse_users(){
        
        $dseusers = User::where('role',5)->where('flag', 0)->get();
        
        if(Auth::user()->role == 6){
            $users = DB::table('distributor_user')->where('distributor_id', Auth::user()->id)->get();
            if(!$users->IsEmpty()){
                $dseusers = User::where('role',5)->whereIn('id', $users->id)->where('flag', 0)->get();
            }else{
                $dseusers = [];
            }
        }

        $date_from = $date_to = Carbon::now();
        $date_from = $date_from->format('Y-m-d').' 00:00:00';
        // $date_to = Carbon::now();
        $date_to = $date_to->format('Y-m-d').' 23:59:59';
    
        return view('users.dseusers',compact('dseusers', 'date_from', 'date_to'));
    }

    public function so_users()
    {
        $sousers = User::where('role', 3)->where('flag', 0)->get();
        return view('users.sousers', compact('sousers'));
    }

    public function rm_users()
    {
        $rmusers = User::where('role', 4)->where('flag', 0)->get();
        return view('users.rmusers', compact('rmusers'));
    }

    public function outlets()
    {
        $outlets = Outlet::paginate(10);
        // dd($outlets);
        return view('users.outlets', compact('outlets'));
    }

    public function dse_filter(Request $request)
    {
        $now = Carbon::now();
        if($request->date_from == null){
            $date_from = $now->year."-".$now->month."-01". " 00:00:00";
        }else{
            $date_from = $request->date_from . " 00:00:00";
        }

        if($request->date_to == null){
            $date_to = $now. " 23:59:59";
        }else{
            $date_to = $request->date_to . " 23:59:59";

        }
        // dd($request->date_from, $date_from);
        // $dseusers = User::where('role',5)->get();
        $i = 0;
        
        if($request->filter_by == "DSE"){

            $dseusers = User::where('role',5)->where('id', $request->filtername)->get();

        }elseif($request->filter_by == "Sub D"){
            $sales_data = Sale::where('distributor_id', $request->filtername)->whereBetween('created_at', [$date_to, $date_from])->with('user')->get();

            $sales = $sales_data->unique('sales_officer_id');

            foreach($sales as $user){
                $dseusers[] = $user->user;
            }
            if($sales->isEmpty()){
                $dseusers = [];
            }
            
        }elseif($request->filter_by == "Routewise"){

            $sales_data = RouteLog::where('route', $request->filtername)->whereDate('created_at', [$date_to, $date_from])->with('dse')->get();
            $sales = $sales_data->unique('salesofficer_id');
            foreach($sales as $user){
                $dseusers[] = $user->dse;
            }
            if($sales->isEmpty()){
                $dseusers = [];
            }

        }else{

            $dseusers = User::where('role',5)->get();

        }
        return view('users.dseusers',compact('dseusers', 'date_to', 'date_from'));
    }
    
    public function user_filter($id)
    {
        if (Auth::user()->type == 1) {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $users = User::where('type', 1)->where('regionalmanager', Auth::user()->id)->where('id', $id)->whereIn('role',[3,5])->get();
            }
            //Admin
            else {
                $users = User::where('type', 1)->whereIn('role', [3, 4, 5])->where('id', $id)->get();
            }
            //Trading
        } else {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $users = User::where('type', 2)->where('regionalmanager', Auth::user()->id)->where('id', $id)->whereIn('role',[3,5])->get();
            }
            //Admin
            else {
                $users = User::where('type', 2)->whereIn('role',[3, 4, 5, 6])->where('id', $id)->get();
            }
        }
        // dd($users);

        return view('users.index')
            ->with('users', $users);
    }

    public function user_filter_by_flag(Request $request)
    {
        if (Auth::user()->type == 1) {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $users = User::where('type', 1)->where('regionalmanager', Auth::user()->id)->whereIn('role',[3,5])->where('flag',$request->flag)->get();
            }
            //Admin
            else {
                $users = User::where('type', 1)->whereIn('role', [3, 4, 5])->where('flag',$request->flag)->get();
            }
            //Trading
        } else {
            //RegionalManager
            if (Auth::user()->role == 4) {
                $users = User::where('type', 2)->where('regionalmanager', Auth::user()->id)->whereIn('role',[3,5])->where('flag',$request->flag)->get();

            }
            //Admin
            else {
                $users = User::where('type', 2)->whereIn('role',[3, 4, 5, 6])->where('flag',$request->flag)->get();
            }
        }
        // dd($users);

        return view('users.index')
            ->with('users', $users);
    }

    public function day_wise_route_setup($id)
    {
        $user_schedule = DayWiseRouteSetup::where('user_id', $id);
        $user_quotation = Quotation::where('user_id', $id);
        $user = User::where('id', $id)->first();
        $routes = RouteName::whereHas('route_users', function ($query) use ($id) {
            $query->where('user_id','=', $id);
        })->get();

        $user_data = $user_schedule->get();
        $user_check = $user_schedule->first();
        
        $days = [
            0 => 'Sunday',
            1 => 'Monday',
            2 => 'Tuesday',
            3 => 'Wednesday',
            4 => 'Thursday',
            5 => 'Friday',
            6 => 'Saturday',
        ];
        if(isset($user_check)){
            $route_data = $user_data; // Edit
        }else{
            $route_data = null; // Store since no data in that table
        }

        // dd($route_data);

        return view('route_names.day_wise_route_setup', compact('routes', 'days', 'route_data'))->with('user', $user);
    }

    public function store_day_wise_route_setup(Request $request)
    {
        for ($i=0; $i<7; $i++) { 
            // dd($request->routename[$i], $request->day[$i]);
            DayWiseRouteSetup::create([
                'user_id' => $request->user_id,
                'route_id' => $request->routename[$i],
                'day' => $request->day[$i],
            ]);
        }
        
        Flash::success('Routewise DSE Assigned Successfully.');
        return redirect(route('user.index'));
    }

    public function update_day_wise_route_setup($id, Request $request)
    {

        // dd($request->all(), $id);

        for ($i=0; $i < 7; $i++) { 
            DayWiseRouteSetup::where('user_id', $id)->where('day', $request->day[$i])->update([
                'route_id' => $request->routename[$i],
            ]);
        }

        Flash::success('Routewise DSE Updated Successfully.');
        return redirect(route('user.index'));
    }

    public function add_in_bulk_user()
    {
        $code = ['AO00018','AA00001','AC00001','AD00001','AJ00001','AJ00002','AK00002','AK00001','AM00002','AM00003','AM00001','AN00001','AC00008','AN00002','AP00001','AR00003','AR00004','AO00021','AR00001','AR00002','AC00005','AS00003','AS00004','AS00001','AS00007','AC00010','B 00001','B 00003','BO00017','BA00003','BB00001','BH00004','BH00001','BH00007','BH00003','BH00002','BH00006','BI00002','BI00001','BC00004','BI00003','BO00001','BU00001','CH00002','CH00001','DC00003','DC00002','DE00002','DH00002','DH00001','DI00001','DU00002','DU00001','EV00012','GC00004','GA00003','GA00007','GA00001','GA00005','GC00001','GL00001','GO00003','GO00001','GC00003','GY00002','GY00001','HA00001','HB00001','HC00002','HI00001','HI00002','IR00001','IC00002','JC00006','JA00005','JA00006','JA00001','JA00003','JA00007','JA00004','JA00002','JD00001','JE00001','JM00001','JC00007','KA00001','KA00009','KA00006','KA00002','KA00003','KA00007','KB00002','KH00001','KH00002','KN00001','KR00001','LC00095','LR00001','LC00097','MA00008','MA00003','MA00017','MA00014','MA00004','MA00005','MC00004','MA00015','MA00001','MA00018','MC00007','MA00016','MA00010','MA00002','ME00001','MC00006','MI00001','MO00003','MO00001','MO00002','MC00008','NC00003','NC00011','NA00001','NA00002','NA00003','NA00013','NA00005','NA00008','NB00002','NE00009','NE00001','NC00004','NE00002','NE00020','NC00005','NE00021','NE00014','NE00010','NE00013','NC00010','NE00004','NE00005','NE00022','NE00006','NE00023','NE00011','NE00015','NC00006','NE00024','NE00026','NE00008','NC00002','NC00009','NI00001','NP00002','OL00001','OM00001','OM00003','OC00001','OM00004','OM00002','OO00003','P 00001','PA00001','PA00007','PA00008','PA00002','PA00005','PA00003','PK00001','PO00004','PR00005','PR00002','PR00001','PO00030','PC00001','PU00001','RC00005','RC00001','RA00010','RA00011','RO00031','RC00004','RA00003','RA00002','RB00001','RD00002','RI00002','RS00001','RU00001','S 00001','SC00013','SA00011','SA00001','SA00002','SA00003','SA00014','SA00018','SC00018','SC00012','SA00012','SA00007','SC00015','SC00009','SH00005','SH00006','SH00007','SH00023','SH00013','SH00028','SC00006','SH00003','SC00022','SC00011','SH00004','SC00014','SC00008','SC00005','SC00021','SC00020','SH00008','SC00007','SH00020','SH00021','SH00009','SH00010','SH00024','SH00025','SC00003','SH00026','SH00012','SH00027','SH00018','SI00001','SC00002','SP00003','SP00002','SP00004','SR00002','SR00001','SU00002','SU00005','SU00004','SU00001','SU00007','SU00008','SU00003','SW00001','SW00005','TC00002','TH00001','TH00002','TI00001','TR00001','TR00002','UN00001','YA00001'];
        $dis_name = ['AALAMDEVI SUPPLIERS-FULBARI-POKHARA','AARAV ENTERPRISES & SUPPLIERS-NIJGADH','ACHARYA SANJEEV AND SANJAYA BROTHER-GHORAHI','ADITYA SUPPLIERS-NEPALGUNJ','AJIT KIRANA PASAL AND SUPPLIERS-BARDIBAS','AJIT NEW KIRANA-MANGALPUR','AK MARKETING-BHAKTPUR','AKALA GAULE KIRANA PASAL-THARPU','AMBEKESWORI TRADERS-KHUSIBU','AMBEY KIRANA BHANDAR-KALAIYA','AMRIT TRADERS-NIJGADH','ANANT TRADING-RAJBIRAJ','ANISH SUPPLIERS-TOKHA-KATHMANDU','ANUP TRADE LINK-JANAKPUR','AP TRADERS-HETAUDA','ARATI TRADERS-BUTWAL','ARCHITA TRADE AND RASAN SUPPLIERS-BHALUWANG','ARNAB AND ARCHIT SUPPLIERS-NEPALGUNJ','ARUN TRADING-DHANGADI','ARYAN TRADERS-JANAKPUR','ASHIKA STORES AND SUPPLIERS-BENI-MYAGDI','ASHIM AND AGRIM STORES-GORKHA','ASHOK AND BROTHERS SUPPLIERS-GAJURI','ASMA TRADE CONCERN-DHANGADI','ASTHA TRADERS-GHORAHI','AVASH TRADING COMPANY PVT.LTD-LALITPUR','B AND B SUPPLIERS-JAJARKOT','B AND BROTHERS SUPPLIERS-KAPAN','BAGEHITI SUPPLIERS PVT.LTD-SAMAKHUSI','BAJRANG STORE-TRISULI','BBM SUPPLIERS-ROLPA','BH MARKETING-SINDHULI','BHANDARI STORES-SURKHET','BHATBHATENI SUPER MARKET AND DEPARTMENTAL STORE','BHIMSEN DISTRIBUTERS-DHARAN','BHUPENRA STORES AND ORDER SUPPLIERS-DAILEKH','BHUSAL STORES & SUPPLIERS-POKHARA','BIJAYA SUPPLIERS-HETAUDA','BIMESH TRADERS-BIRATNAGAR','BIR ENTERPRISES-BIRGUNJ','BISHAL KIRANA PASAL-ROLPA','BOLBAM KIRANA PASAL-RAMGOPALPUR','BUDHATHOKI STORES-SALYAN','CHAUDHARY DISTRIBUTOR-JANAKPUR','CHAULAGAIN DEPARTMENTAL STORE PVT. LTD. -LAMKI','DEURALI UPABHOKTA SAHAKARI SANSTHA LIMITED-BUTWAL','DEV SITA SUPPLIERS-AMAURI','KAILALI','DEVENDRA KIRANA PASAL-KAPILVASTU','DHAKAL BIBIDH SUPPLIERS-RAMPUR','DHAULAGIRI TRADERS-KUSMA','DIVYAM TRADERS-THIMI','DURGA BHAWANI TRADERS-POKHARA','DURGA TRADE CONCERN-DHANGADI','EXPERT CHEMICAL NEPAL PVT. LTD.','GAGAN KIRANA PASAL-PYUTHAN','GANESH AND SWIKRITI TRADERS-POKHARA','GANGA BROTHERS SUPPLIERS-GULMI','GAUDIBAG DISTRIBUTORS-DADELDHURA','GAUTAM SHREE WALL MART PVT LTD-KULESHWOR','GAYATRI TRADING-LAMAHI','GLORIOUS MARKETING-KALIMATI','GO AND GROW GROCERIES-SALYAN','GOMATA ENTERPRISES-KAWASOTI','GURASH TRADE LINK PVT.LTD-THULOBHARYANG','GYAN TRADING-BHAIRAWA','GYAWALI TRADING-NARAYANGHAT','HARI BINITA & SONS-SYANGJA','HB TRADERS-BURTIBANG','HEMANTA GENERAL STORE-BIRENDRANAGAR-SURKHET','HIM GANGA TRADE CONCERN-DHANGADI','HIMCHULI SALES AND TRAVELS-MIRCHAIYA','IRU GENERAL STORE-ILAM','ISHAN SUPPLIERS-FIDIM','JAGAT SUPPLIERS-BURTIBANG-BAGLUNG','JAGATRA DEVI STORE-GALAYNG','JALAPA MARKETING AND SUPPLIERS-TRISULI','JAY DURGA BHUMIRAJ TRADE SUPPLIERS-DHANGADI','JAY MAA SONASATI TRADERS-JANAKPUR','JAY MANAKAMANA ENTERPRISES-BANEPA','JAY SHREE SHYAM TRADERS-DUHABI','JAYA HANUMAN GALLA KIRANA PASAL-KATARI','JD SUPPLIERS-GULARIYA','JENIKA TRADERS-KALAIYA','JMC TRADING PVT LTD-NEPALGUNJ','JYOTI TRADE AND SUPPLIERS-DHANGADI','KALAPATHAR TRADERS-DHANGADI','KALIKA SHREE TRADE SUPPLIERS-BHALWARI','KALPANA KHADYA STORE-BANEPA','KAMAKSHA TRADING-DAMAK','KAMINI GENERAL STORES-DHALKEBAR','KARAN TRADE HOUSE PVT. LTD-KULESHWOR','KB AND RARA GENERAL STORE-JUMLA','KHADKA SUPPLIERS-DANG','KHANAL GALLA PASAL-LAMAHI','KN ENTERPRISES-SANFE','ACCHAM','KRISHNA TRADING-LAMAHI','LATINATH NIMUN TRADE SUPPLIERS-','KANCHANPUR','LR TRADERS-DHANGADI','LUCKY DIVYASHWORI SUPPLIERS PVT.LTD-DHOBICHAUR-KATHMANDU','MA JAGDAMBA MARKETING-DAMAK','MAA DURGA GENERAL SUPPLIERS-LALBANDI','MAA JANKI ENTERPRISES-JANAKPUR','MAA KALI AND LAXMI ENTERPRISES-BANESHWOR','MAA KALI GENERAL STORE-RAJBIRAJ','MAA KALI MARKETING-DAMAK','MAHATARA STORE-MUSIKOT-RUKUM','MAHESH KIRANA PASAL-DIKTEL','MALLA SUPPLIERS-DHANGADI','MANAKAMANA GENERAL SUPPLIERS-GAUR','MANAKAMANA SUPPLIERS-DHUMBARAI-KATHMANDU','MANDALI MAI KIRANA STORE-KULESHWOR','MANOJ ENTERPRISES-GOLBAZAAR','MAYALU TRADERS-NARYANPUR','MEGA MART PVT LTD-LAZIMPART','METRO MARKET PVT.LTD','MISHRA ENTERPRISES-PATAN','MOHAN KIRANA PASAL-HARIWAN','MOHANI TRADERS-NARAYANGHAT','MOHIT TRADERS-POKHARA','MUNA STORE-JORPATI-GOKARNESHWOR','N.K. SUPPLIERS-ODARI-KAPILBASTU','N.P.F. KIRANA STORES-POKHARA-LEKHNATH','NABIN DISTRIBUTORS-DADELDHURA','NABIN TRADERS-DAMAK','NAGBANSHI TRADERS AND SUPPLIERS -DHANGADHI','NAMO BUDDHA GENERAL STORES-BUTWAL','NAMUNA TRADE AND DISTRIBUTERS-CHAINPUR','NARAYAN KIRANA PASAL-BALEWA','NB ENTERPRISES-BANEPA','NEHA KIRANA STORES-JANAKPUR','NEUPANE TRADERS-LAMKI','NEW ASMITA TRADE SUPPLIERS-DHANGADI','NEW BHAGESHWOR ENTERPRISES-MAHENDRANAGAR','NEW BHARI STORES-DANG','NEW BUDDHA STORES-BUTWAL-RUPANDEHI','NEW DURGA STORES-BUTWAL','NEW HIMALAYAN SUPPLIERS - BANEPA','NEW K AND K SUPPLIERS-ITHARI','NEW KANTIPUR STORE-NAYABAZAAR','NEW KRISHNA KIRANA STORE-TULSIPUR','NEW MAHAKALI SUPPLIERS-DHANGADI','NEW MALLIKARJUN GENERAL STORE-DARCHULA','NEW PRABHAT SUPPLIERS-TAULIHAWA','NEW RADHIKA SUPPLIERS-SURKHET','NEW RASHI AND SUBEDI GENERAL STORE-PYUTHAN','NEW SHIVAM TRADERS-HETAUDA','NEW SHREE RAM TRADERS-GARUDA','NEW SIDHHAKALI TRADING CENTER-ITAHARI','NEW SINDUR KIRANA PASAL-TULSIPUR','NEW SISNERI TRADERS PVT LTD-SWAYAMBHU','NEW SRIJANA SUPPLIRES-MAHENDRANAGAR','NEW UMA STORE-JANAKPURDHAM','NEW VALLEY SUPPLIERS-BALKHU','NIRAK GENERAL STORE-SURKHET','NP SUPPLIERS-PALPA','OLI BROTHERS AND SUPPLIERS-RUKUM','OM DEVKOTA GENERAL STORE-TIKAPUR','OM KHADHYA BHANDAR-TADI','OM SAPKOTA TRADERS-DEVDAHA-RUPANDEHI','OM STORE-THALI','OM TRADING-INARUWA','OORJALEVER COMPANY PVT LTD-SATUNGAL','P AND P SUPPLIERS-MANTHALI','PARAJULI SUPPLIERS-RAJAPUR','PARAJULI TRADE SUPPLIERS - KOTESHWAR','PARUL ENTERPRISES-PATAN','PASCHIMANCHAL STORE-NEPALGUNJ','PASHUPATINATH SUPPLIERS PVT LTD-BIRTAMODE','PATHAK MARKETING-MAHENDRANAGAR','PK TRADE CONCERN-LAMKI','POKHREL KHADYANNA TATHA KIRANA PASAL-LAMAHI','PRABHAT ENTERPRISES-BARATHWA','PRADHAN BROTHERS-BAGLUNG','PRASHANNA SUPPLIERS-NEPALGUNJ','PRATIBHA PRABIN SUBEDI STORES-GULMI','PREM GENERAL STORE-SANDHIKHARKA-ARGAKHACHI','PUNAM SUPPLIERS-PALPA','R.B. TRADERS-MAALEPATAN-POKHARA','RAJ SONIYA SUPPLIERS-POKHARA','RAJKUMARI KIRANA STORES -JANAKPUR','RAM JANAKI KIRANA PASAL-BARATHWA','RAMBHA ENTERPRISES-BIRTAMODE','RAMPUR SUPPLIERS-RAMPUR-PALPA','RAMWATI SUPPLIERS-BIRATNAGAR','RATHUR GENERAL STORE-NEPALGUNJ','RBS TRADERS-POKHARA','RD ENTERPRISES-BUTWAL','RIYA SUPPLIERS-JITPUR','RS MARKETING STORES-KAWASOTI','RUDRA DEVI ENTERPRISES-NARAYANGHAT','S SUPPLIERS-AABUKHAIRENI','S.T.M SUPPLIERS-PYUTHAN','SABIN KIRANA PASAL-THANKOT','SAGARMATHA DEPARTMENTAL STORE PVT. LTD. - GAIGHAT','SAGARMATHA TRADE LINK-ITHARI','SAGARMATHA TRADING & MARKETING-RAJBIRAJ','SAIBABA TRADERS-CHANDRAUTA','SAJAN TRADERS-SWAYAMBHU','SALA VENA SUPPLIERS-DAMAK','SAMIKSHYA ORDER AND SUPPLIERS-PYUTHAN','SAPANA TIRTHA TRADERS-MANDIKHATAR','SAROJ AND BROTHERS-BAGLUNG','SEEMA GENERAL STORES-SURKHET','SHANKAR & SONS TRADING-BIRGUNJ','SHANKAR STORE-BIRTAMODE','SHANKER TRADERS-ITHARI','SHANTI TRADERS-BIRATNAGAR','SHIVA ASTHA ENTERPRISES-SUNWAL','SHIVA BABA SUPPLIERS-LAMJUNG','SHRADHA AND SAMPANNA TRADERS-GAJURI','SHREE BANDALI ORDER AND SUPPLIERS-SURKHET','SHREE BHAGESWOR TRADE AND CONCERN-MAHENDRANAGAR','SHREE BHIMESHWOR SUPPLIERS-NIJGADH','SHREE DHARMARAJ TRADERS-BARDIBAS-MAHOTTARI','SHREE DURGA STORES AND ORDER SUPPLIERS-DAILEKH','SHREE GANESH TRADERS-HARIWAN','SHREE GAUR NITAE COSMETIC PASAL-GAUR-RAUTAHAT','SHREE GAYATRI ENTERPRISES-JANAKPUR','SHREE KIHU KALIKA PACKAGING & SUPPLIERS-NAWALPUR','SHREE KRISHNA TRADERS-KUSMA','SHREE MAHALAXMI SUPPLIERS-URLABARI','SHREE PRATIK TRADERS--MAHENDRANAGAR','SHREE RAM KIRANA AND GENERAL SUPPLIERS-GAUR','SHREE RAM TRADERS-JANAKPUR','SHREE RANI SATI SUPPLIERS-BIRGUNJ','SHREE SUMAN TRADERS-BIRATNAGAR','SHREE SWAGDWARI SUPPLIERS-ROLPA','SHREE UMA SUPPLIERS-BUTWAL','SHREERAM ENTERPRISES-GAUSHALA','MAHOTTARI','SHRESTHA ORDER FOR SUPPLIERS-BHINGRI','SHRESTHA STORE-KHADBARI','SHUVAKAMANA TRADERS-PYUTHAN','SHYAM VARIETY SUPPLIERS-CHARIKOT','SIDHHAKALI TRADE AND SUPPLIERS-BHOJPUR','SIMCHAUR TRADE LINK-MAHALAXMI 1 LALITPUR','SP SALES AND SERVICE-TULSIPUR','SP STORES AND SUPPLIERS-LALBANDI','SP SUPPLIERS-JITPUR','SR TRADERS-BUTWAL','SRIJANA TRADING-HADIGAUN','SUBHA LAXMI TRADERS -HARIWAN','SUBHA SANDESH STORE-BENI','SUBHA SHREE SUPPLIERS-DAMAULI','SUBHAM TRADERS-MELKUNA','SUGHANDA ENTERPRISES-BANEPA','SUNIL KIRANA PASAL-RAMGOPALPUR','SURYA DEEP TRADERS-RAJBIRAJ','SWASTIK TRADERS-LAHAN','SWASTIKA SUPPLIERS-DANG','TEAM TRADE PVT.LTD-SHANKHARAPUR-SAKHU','THAPA MARKETING CENTRE-KANCHANPUR','THREE BROTHER TRADERS-GADYAULI','TIMALSINA BROTHERS TRADERS -POKHARA','TRIMURTI TRADE AND SUPPLIERS-DHARAN','TRINETRA MARKETING-TADI','UNITED ENTERPRISES-HILE','YASBANTA TRADERS-RAUTAHAT'];
        $number = ['9856050719','9811809381','9857830369','9848025552','9801640540','9824458636','9841240816','9856031453','9843718450','9855025604','9855022366','9852820288','0','9854027061','9845027403','9857039950','9801334158','0','9819966905','9845023444','0','9856040393','9841618874','9848601299','9857830080','0','9858027613','9851149290','9802311350','9851175322','9847939390','9851007555','9848076350','0','9852045917','9858078589','9866350463','9845456238','9852027461','0','9857822622','9812040459','9857821489','9801662206','9858424437','0','0','9857050280','9857065739','9857631369','9851028011','9857630012','9848543941','0','0','9856054315','9801359899','9848452787','0','0','9841339568','9847835362','9857028044','0','9811430643','9855084621','9856028617','9857625890','0','9848592374','9860630500','9852680915','0','0','9846044117','9851218615','9848830516','9854028511','9851079820','9852021492','9842806900','9825510001','9801335101','9858024198','0','9858420105','9857031520','9851065650','9842621251','9801098992','9801146850','9858052516','9857834295','9857841086','9848622463','9847830721','0','9858421778','0','9842621576','0','9807629457','9741169475','9807721999','9842621576','9868236704','9862980045','9749018323','9855021470','0','0','9842839442','9848603957','0','0','9843764195','9807824724','0','9856027050','0','0','0','9848703019','9801422714','9802977350','9847128877','9852051200','9857634032','9841637599','0','9848433997','0','9858750385','9857831833','0','071-546723','9851099505','9813262249','0','0','9848612413','9848793270','9857050280','9858066166','0','9855068151','9855040551','0','9847823996','9851060363','9858750374','0','0','9858050329','9847103532','9748518822','9848457227','9855060453','0','9851083136','9852046915','9841339219','9854043044','9848147461','9841769566','9851071499','9801458999','9802678593','9858750045','9815616070','9806226823','9741023339','9857620021','9858025964','0','0','0','0','0','9864274984','9854026065','0','0','9807011601','9858024751','9815100563','9857025956','9824252464','9867191742','9845053163','9856040417','0','9841879116','9815787449','9852027084','0','9857022862','0','0','0','9851118369','9857620259','0','0','9852680845','9842492359','9852025026','9857045703','9846016766','9841179002','0','0','0','0','9848156045','0','0','0','0','0','9807085401','0','9855021470','9804812528','9855025118','0','9748523478','9815426699','0','98478445571','9842158041','9857836520','9861058142','9842174325','9801851460','9868630875','9803664298','9867149583','9857072429','9841010701','0','9857640213','9846059945','9848022463','9851064605','9807837186','031-521494','9842826717','0','0','9858750079','9801065639','9815100563','9852049248','9845079661','9825303937','9845100627'];
        $location = ['POKHARA','NIJGAD','DANG','NEPALGUNJ','BARDIBASH','MANGALPUR','BHAKTAPUR','THARPU','KHUSBU','KALAIYA','NIJGAD','RAJBIRAJ','TOKHA KATHMANDU','JANAKPUR','HETAUDA','BUTWAL','BHALUWANG','NEPALGUNJ','DHANGADHI','JANAKPUR','BENI','GORKHA','GAJURI','DHANGADHI','DANG','LALITPUR','JAJARKOT','KAPAN','SAMAKHUSHI ','TRISULI','ROLPA','SINDULI ','SURKHET','KATHMANDU','DHARAN','DAILEKH','POKHARA','HETAUDA','BIRATNAGAR','BIRGUNJ','ROLPA','RAMGOPALPUR','SALYAN','JANAKPUR','LAMKI','BUTWAL','KAILALI','KAPILVASTU ','RAMPUR','KUSMA','THIMI ','POKHARA','DHANGADHI','JANAKPUR','PIYUTHAN','POKHARA','GULMI','DADELDHURA','KULESHWAR','LAMAHI','KALIMATI','SALYAN','KAWASWATI ','SWAYAMBHU','BHAIRAHAWA','NARAYANGHAT','SYANGJA','BURTIBANG','SURKHET','DHANGADHI','MIRCHAIYA','ILAM','FIDIM','BAGLUNG','GALYANG','TRISULI','DHANGADHI','JANAKPUR','BANEPA','DUHABI','KATARI','GULARIYA','KALAIYA','NEPALGUNJ','DHANGADHI','DHANGADHI','BHALWARI BUTWAL','BANEPA','DAMAK','DHALKEBAR','KULESHWAR','JUMLA','DANG','LAMAHI','ACHHAM','LAMAHI','MAHENDARAGAR','DHANGADHI','KATHMANDU','DAMAK','LALBANDI','JANAKPUR','BANESHWAR ','RAJBIRAJ','DAMAK','RUKUM','DIKTEL','DHANGADHI','GAUR','KATHMANDU','KULESHWAR','GOLBAZAR ','NARAYANPUR','LAZIMPAT','KATHMANDU','PATAN','HARIWAN','NARAYANGHAT','POKHARA','KAPILVASTU ','POKHARA','POKHARA','DADELDHURA','DAMAK','DHANGADHI LAHAN','BUTWAL','CHAINPUR','BALEWA','BANEPA','JANAKPUR','LAMKI','DHANGADHI ','MAHENDRANAGAR','DANG','BUTWAL','BUTWAL','BANEPA','ITAHARI','NAYABAZAR KATHMANDU','TULSIPUR','DHANGADHI','DARCHULA','TAULIHAWA','SURKHET','PIYUTHAN','HETAUDA','GARUDA','ITAHARI','TULSIPUR','SWAYAMBHU','MAHENDRANAGAR','JANAKPUR','BALKHU','SURKHET','PALPA','RUKUM','TIKAPUR','TANDI','RUPANDEHI ','THALI','INARUWA','SATUNGAL','MANTHALI ','RAJAPUR','KOTESHWAR','PATAN','NEPALGUNJ','BIRTAMOD','MAHENDRANAGAR','LAMKI ','LAMAHI ','BARAHATWA ','BAGLUNG','NEPALGUNJ','GULMI ','ARGAKHACHI ','PALPA','POKHARA','POKHARA','JANAKPUR','BARAHATWA ','BIRTAMOD','RAMPUR PALPA ','BIRATNAGAR','NEPALGUNJ','POKHARA','BUTWAL ','JITPUR','KAWASWATI ','NARAYANGHAT','AABUKHAIRENI ','IYUTHAN','THANKOT','GAIGHAT','ITAHARI','RAJBIRAJ','CHANAUTA ','SWAYAMBHU','DAMAK','PIYUTHAN','MANDIKHATAR','BAGLUNG','SURKHET ','BIRGUNJ','BIRTAMOD','ITAHARI','BIRATNAGAR','SUNAWAL','LAMJUNG','GAJURI ','SURKHET ','MAHENDRANAGAR','NIJGAD','BARDIBASH','DAILEKHA','HARIWAN','GAUR','JANAKPUR','NAWALPUR','KUSMA ','URLABARI','MAHENDRANAGAR','GAUR','JANAKPUR','BIRGUNJ','BIRATNAGAR','ROLPA','BUTWAL','GAUSHALA ','BHINGRI PIYUTHAN','KHADBARI','PIYUTHAN','CHARIKOT','BHOJPUR','LALAITPUR','TULSIPUR','LALBANDI','JITPUR','BUTWAL','HADIGAUN','HARIWAN','BENI ','DAMAULI','MELKUNA','BANEPA','RAMGOPALPUR','RAJBIRAJ','LAHAN','DANG','SANKHU','KANCHANPUR','GADYAULI','POKHARA','DHARAN','TANDI','HILE','RAUTAHAT'];
    
        for ($i=0; $i < count($code); $i++) { 
            Distributor::create([
                'code' => $code[$i],
                'name' => $dis_name[$i],
                'contact' => ($number[$i] == 0) ? mt_rand(9800000000, 9899999999) : $number[$i],
                'location' => $location[$i]
            ]);
        }

    }

    public function add_in_bulk()
    {
        $email = ['bk.gsipl@gmail.com','iamuttam44@gmail.com','katuwalbishnu151@gmail.com','shahsanjay328@gmail.com', 'adhikarisunil710@gmail.com','sarojmishrajanakpur@gmail.com','sujeetchaudhary766@gmail.com','jhasiddhartha84@gmail.com','mahanandachamlagai57@ gmail.com','rajulaxmi2056@gmail.com','girishyamkumar01@ gmail.com','suryaprasadbagale@gmail.com','adhikariudhab5@gmail.com','anillama390@gmail.com','rrghimire52@gmail.com','idilip26@gmail.com','gsipl.amrit@gmail.com','paudelkedar897@gmail.com','bijayarajbhandari01@gmail.com','humagaindaya040@gmail.com', 'kdhakal471@gmail.com','neupaneshankar70@gmail.com', 'madhuadhikari333@gmail.com','bodikc123@gmail.com','gopalrana2099@gmail.com','Krishnabahadurdangi63@gmail.com','paudelsantosh452@gmail.com','sarmilarayamajhi29@gmail.com','bashyalgautam797@gmail.com','deepusing934@gmail.com','bisnubasnet321@gmail.com','jagannath@yahoo.com','harishmahara739@gmail.com','aniltharu900@gmail.com','lokendrabhandrai@gmail.com'];
        $name = ['BALKRISHNA JI','UTTAM POUDEL','BISHNU KATWAL','SANJAY SHAH','SUNIL ADHIKARI','SAROJ MISRA','SUJIT KUMAR CHAUDHARY','SIDDHARTHA JHA','MAHANANDA CHAULAGAIN','RAJU KUMAR KHATRI POUDEL','SHYAM KUMAR GIRI','SURYA PRASAD BAGALE','UDHAV ADHIKARI','ANIL LAMA','RISHIRAM GHIMIRE','DILIP LAMA','AMRIT POUDEL','KEDAR POUDEL','BIJAY RAJ BHANDARI','DAYARAM HUMAGAIN','KRISHNA DHAKAL','SANKAR NEUPANE','MADHUSUJAN ADHIKARI','BODI BDR KC','GOPAL RANA CHHETRI','KRISHNA BAHADUR DANGI','SANTOSH POUDEL','SHARMILA RAYAMAJHI','KRISHNA BASYAL','DEEPAK SINGH','BISHNU BASNET','JAGANATH PANTA','HARISH MAHARA','ANIL CHAUDHARY','LOKENDRA BHANDARI'];
        $number = ['9801146835','9801146844','9801146836','9801146837','9801146834','9801146901','9801146814','9801146841','9816934206','9801146931','9801146838','9801146827','9801146839','9801237058','9841260818','9823615234','9801146821','9802850007','9814137792','9801237056','9801146831','9801146905','9847071049','9801146823','9801146822','9801146971','9843692135','9863173519','9847437295','9801146826','9801146824','9801146906','9869118824','9801146829','9818502349'];
        for ($i=0; $i < count($name); $i++) { 
            User::create([
                'role' => 5,
                'type' => 1,
                'name' => $name[$i],
                'phone' => $number[$i],
                'username' => Str::slug($name[$i]),
                'email' => $email[$i],
                'password' => Hash::make('12345678'),
            ]);
        }
    }
}
