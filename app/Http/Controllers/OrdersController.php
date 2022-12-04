<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Order;
use App\Repositories\OrderRepository as OrderRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class OrdersController extends Controller
{
    public $orderRepository;


    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'service_id' => 'required|numeric',
            'from' => 'required|min:4',
            'to' => 'required|min:4',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'image_front' => 'required',
            'image_back' => 'required',
            'image_ticket' => 'required',
            'image_passport' => 'required',
            'payment_method' => 'required',
            'payment_status' => 'required',
            'total' => 'required',
            'status' => 'required|in:pending,processing,delivering,completed,cancelled,refunded',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        $data_request = $request->except(['image_front','image_back','image_ticket','image_passport']);
        $data_request['image_front'] = $this->uploadImage($request,'image_front');
        $data_request['image_back'] = $this->uploadImage($request,'image_back');
        $data_request['image_ticket'] = $this->uploadImage($request,'image_ticket');
        $data_request['image_passport'] = $this->uploadImage($request,'image_passport');
        $data_request['user_id'] = Auth::user()->id;
        try {
            $order = $this->orderRepository->store_order($data_request);
            if ($order)
                return response()->json(['status' => 'success', 'message' => 'Order Created Successfully', 'data' => $order]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function get_orders_by_user_id()
    {

        try {

            $orders = $this->orderRepository->get_orders_by_user_id();
            if (isset($orders) && count($orders) > 0)
                return response()->json(['status' => 'success', 'data' => $orders]);
            else
                return response()->json(['status' => 'success','data' => [], 'message' => 'Orders Not Found']);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    protected function uploadImage(Request $request,$image_name)
    {

        if (!$request->hasFile($image_name))
            return;

        $file = $request->file($image_name);
        return $file->store('uploads', 'public');

    }



}
