<?php

namespace App\Http\Controllers\Dashboard;


use App\Models\Category;
use App\Models\Driver;
use App\Models\NotificationData;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository as OrderRepository;
use App\Services\NotificationClass;
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

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $orders = $this->orderRepository->index();
            if (isset($orders) && count($orders) > 0)
                return response()->json(['status' => 'success', 'data' => $orders]);
            else
                return response()->json(['status' => 'error','data' => '', 'message' => 'Not Orders Found',], 404);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function create()
    {

    }
    public function show($order_id)
    {
        try {
            $order = $this->orderRepository->show($order_id);
            if (isset($order))
                return response()->json(['status' => 'success', 'data' => $order]);
            else
                return response()->json(['status' => 'error','data' => '', 'message' => 'Not Orders Found',], 404);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
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

        $data_request = $request->post();
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

    public function edit($id)
    {

    }


    public function update(Request $request, $id)
    {
        if (!$order_check = $this->orderRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Order ID Not Found',], 404);

        $validator = Validator::make($request->all(), [
            'user_id' => 'required|numeric',
            'service_id' => 'required|numeric',
            'from' => 'required|min:4',
            'to' => 'required|min:4',
            'appointment_date' => 'required',
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

        $data_request = $request->post();
        try {
            $order = $this->orderRepository->update_order($data_request, $id);
            if ($order)
                return response()->json(['status' => 'success', 'message' => 'Order Updated Successfully', 'data' => $order]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function update_status(Request $request, $id)
    {
        if (!$order_check = $this->orderRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Order ID Not Found',], 404);

        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,processing,delivering,completed,cancelled,refunded',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        $data_request = $request->post();
        try {
            $order = $this->orderRepository->update_order($data_request, $id);
            if ($order)
                return response()->json(['status' => 'success', 'message' => 'Order Updated Successfully', 'data' => $order]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function assign_order_to_driver(Request $request, $id)
    {
        if (!$order_check = $this->orderRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Order ID Not Found',], 404);

        $driver = Driver::find($request->driver_id);
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        $data_request = $request->post();
        try {
            $order = $this->orderRepository->assign_order($data_request, $id);
            $NotificationClassTilte = " ! لديك رحلة جديد ورقم الطلب {$order->id}";
            $NotificationClassDesc = " لديك رحلة جديد";
            $NotificationClass = NotificationClass::fcmPushNotification(Auth::user()->fcm_token, $NotificationClassTilte, $order, 'web');
            if ($NotificationClass) {
                NotificationData::create([
                    'sender_id' => 'Mashawir App',
                    'receiver_token' => $driver->fcm_token,
                    'title' => $NotificationClassTilte,
                    'description' => $NotificationClassDesc,
                    'image' => '',
                    'action' => 'assign_order',
                    'type' => 'assign',
                    'platform' => 'web',
                ]);
            }
            if ($order)
                return response()->json(['status' => 'success', 'message' => 'Order Assigned To Driver  Successfully', 'data' => $order]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function destroy($id)
    {
        if (!$order_check = $this->orderRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Order ID Not Found',], 404);

        try {
            $order = $this->orderRepository->destroy_order($id);
            return response()->json(['status' => 'success', 'message' => 'Order Deleted Successfully']);
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


}
