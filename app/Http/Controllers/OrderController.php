<?php

namespace App\Http\Controllers;

use Flash;
use Response;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\OrderRepository;
use App\Http\Requests\CreateOrderRequest;
use App\Http\Requests\UpdateOrderRequest;
use App\Http\Controllers\AppBaseController;

class OrderController extends AppBaseController
{
    /** @var  OrderRepository */
    private $orderRepository;

    public function __construct(OrderRepository $orderRepo)
    {
        $this->orderRepository = $orderRepo;
    }

    /**
     * Display a listing of the Order.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $orders =Order::orderby('id','desc')->paginate(10);

        return view('orders.index')
            ->with('orders', $orders);
    }

    /**
     * Show the form for creating a new Order.
     *
     * @return Response
     */
    public function create()
    {
        return view('orders.create');
    }

    /**
     * Store a newly created Order in storage.
     *
     * @param CreateOrderRequest $request
     *
     * @return Response
     */
    public function store(CreateOrderRequest $request)
    {
        // dd("hello");
        $input['order_id']=$request->order_id;
        $input['distributor_id']=$request->distributor_id;
        $input['quantity']=json_encode($request->quantity);

        $order = $this->orderRepository->create($input);

        Flash::success('Order send successfully.');

        return redirect(route('home'));
    }

    /**
     * Display the specified Order.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        return view('orders.show')->with('order', $order);
    }

    /**
     * Show the form for editing the specified Order.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        return view('orders.edit')->with('order', $order);
    }

    /**
     * Update the specified Order in storage.
     *
     * @param int $id
     * @param UpdateOrderRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateOrderRequest $request)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        $order = $this->orderRepository->update($request->all(), $id);

        Flash::success('Order updated successfully.');

        return redirect(route('orders.index'));
    }

    /**
     * Remove the specified Order from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $order = $this->orderRepository->find($id);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.index'));
        }

        $this->orderRepository->delete($id);

        Flash::success('Order deleted successfully.');

        return redirect(route('orders.index'));
    }
    public function getorderForm(Request $request){
        // dd($request->all());
        $products= Product::where('flag',0)->pluck('name','id');
        $distributor=Distributor::where('userid',Auth::user()->id)->first();
        $date=Carbon::now()->format('Y-m-d');
        $orderid=time();
        return view('orderForm',compact('distributor','products','date','orderid'));
    }

    public function distributorwise(Request $request){
        $distributor=Distributor::where('userid',Auth::user()->id)->first();
        $orders=Order::where('distributor_id',$distributor->id)->orderby('id','desc')->paginate(10);
        return view('orders.distributororders')
            ->with('orders', $orders);
    }
    public function distributorshow($orderid){
        $order = $this->orderRepository->find($orderid);

        if (empty($order)) {
            Flash::error('Order not found');

            return redirect(route('orders.distributorwise'));
        }

        return view('orders.distributorshow')->with('order', $order);
    }
}
