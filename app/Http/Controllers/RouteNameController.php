<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateRouteNameRequest;
use App\Http\Requests\UpdateRouteNameRequest;
use App\Repositories\RouteNameRepository;
use App\Http\Controllers\AppBaseController;
use App\Models\Channel;
use App\Models\Distributor;
use App\Models\Outlet;
use App\Models\RouteName;
use App\Models\Town;
use App\Models\User;
use Illuminate\Http\Request;
use Flash;
use Response;

class RouteNameController extends AppBaseController
{
    /** @var RouteNameRepository $routeNameRepository*/
    private $routeNameRepository;

    public function __construct(RouteNameRepository $routeNameRepo)
    {
        $this->routeNameRepository = $routeNameRepo;
    }

    /**
     * Display a listing of the RouteName.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $routeNames = RouteName::where('flag', 0)->get();
        // $routeNames = $this->routeNameRepository->all();

        return view('route_names.index')
            ->with('routeNames', $routeNames);
    }

    /**
     * Show the form for creating a new RouteName.
     *
     * @return Response
     */
    public function create()
    {
        $distributors=Distributor::where('manufacturer_trading_type', 2)->pluck('name','id');
        $outlets = Outlet::where('route_id', null)->get();
        // dd($outlets);
        return view('route_names.create',compact('distributors', 'outlets'));
    }

    /**
     * Store a newly created RouteName in storage.
     *
     * @param CreateRouteNameRequest $request
     *
     * @return Response
     */
    public function store(CreateRouteNameRequest $request)
    {
        $input = $request->all();


        $routeName = $this->routeNameRepository->create($input);

        Flash::success('Route Name saved successfully.');

        return redirect(route('routeName.index'));
    }

    /**
     * Display the specified RouteName.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $routeName = $this->routeNameRepository->find($id);
        // dd($id, 'show');

        if (empty($routeName)) {
            Flash::error('Route Name not found');

            return redirect(route('routeName.index'));
        }

        return view('route_names.show')->with('routeName', $routeName);
    }

    /**
     * Show the form for editing the specified RouteName.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $routeName = $this->routeNameRepository->find($id);
        $outlets = Outlet::where('route_id', null)->pluck('name', 'id');
        // dd($outlets);
        if (empty($routeName)) {
            Flash::error('Route Name not found');

            return redirect(route('routeName.index'));
        }
        $distributors=Distributor::where('manufacturer_trading_type', 2)->pluck('name','id');

        return view('route_names.edit',compact('distributors', 'outlets'))->with('routeName', $routeName);
    }

    /**
     * Update the specified RouteName in storage.
     *
     * @param int $id
     * @param UpdateRouteNameRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRouteNameRequest $request)
    {
        $routeName = $this->routeNameRepository->find($id);

        if (empty($routeName)) {
            Flash::error('Route Name not found');

            return redirect(route('routeName.index'));
        }

        $routeName = $this->routeNameRepository->update($request->all(), $id);

        Flash::success('Route Name updated successfully.');

        return redirect(route('routeName.index'));
    }

    /**
     * Remove the specified RouteName from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $routeName = $this->routeNameRepository->find($id);

        if (empty($routeName)) {
            Flash::error('Route Name not found');

            return redirect(route('routeName.index'));
        }


        $outlets = Outlet::where('route_id', $id)->get();

        foreach ($outlets as $outlet) {
            Outlet::where('id', $outlet->id)->update([
                'route_id' => null
            ]);
        }

        $input['flag'] = 1;
        $this->routeNameRepository->update($input, $id);


        Flash::success('Route Name deleted successfully.');

        return redirect(route('routeName.index'));
    }

    public function outlet_map_plot($id)
    {
        $route = RouteName::where('id', $id)->pluck('routename');
        if($id == 0){
            $val = null;
            $allroute = Outlet::where('flag', 0)->where('route_id', null)->get();
            // dd($allroute);
        }else{
            $allroute = RouteName::where('id', $id)->with('outlets')->first();
        }
        $routes = RouteName::all();
        $outlet_logs = Outlet::where('route_id', $id)->where('flag', 0)->whereNotNull('longitude')->get();
        // dd($outlet);
        $positions = [];
        $outlet_name = [];
        if (isset($outlet_logs)) {
            for ($i = 0; $i < sizeOf($outlet_logs); $i++) {
                $item['type'] = 'Feature';
                $item['properties']['title'] = $outlet_logs[$i]->name;
                $item['geometry']['type'] = 'Point';
                $item['geometry']['coordinates'] = [$outlet_logs[$i]->longitude, $outlet_logs[$i]->latitude];

                $positions[$i]=$item;
            }
        }
        
        return view('route_names.outlet_map_plot', [
            'route' => $route,
            'routes' => $routes,
            'positions' => $positions,
            'allroute' => $allroute,
        ]
        );
    }

    public function outlet_list($id)
    {
        $outlets = Outlet::where('flag', 0)->where('route_id', $id)->paginate(50);

        $towns = Town::all();
        $channels = Channel::all();
        $dses = User::where('role', 5)->get();
        $route_id = $id;
        
        return view('outlets.index', compact('outlets', 'towns', 'channels', 'dses', 'route_id'));
    }

    public function route_filter($id)
    {
        $routeNames[] = $this->routeNameRepository->find($id);
        return view('route_names.index')
            ->with('routeNames', $routeNames);
    }
}
