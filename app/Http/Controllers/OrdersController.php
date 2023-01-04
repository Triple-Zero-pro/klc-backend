<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\NotificationData;
use App\Models\Order;
use App\Models\Payment;
use App\Repositories\OrderRepository as OrderRepository;
use App\Services\NotificationClass;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\PayController as PayController;

class OrdersController extends Controller
{
    public $orderRepository;
    public $payController;

    public function __construct(OrderRepository $orderRepository, PayController $payController)
    {
        $this->payController = $payController;
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
            'airport_id' => 'required',
            'status' => 'required|in:pending,processing,delivering,completed,cancelled,refunded',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'success', 'message' => 'Error Validation', 'errors' => $validator->errors()]);

        $data_request = $request->except(['image_front', 'image_back', 'image_ticket', 'image_passport']);
        $data_request['image_front'] = $this->uploadImage($request, 'image_front');
        $data_request['image_back'] = $this->uploadImage($request, 'image_back');
        $data_request['image_ticket'] = $this->uploadImage($request, 'image_ticket');
        $data_request['image_passport'] = $this->uploadImage($request, 'image_passport');
        $data_request['user_id'] = Auth::user()->id;
        try {
            $total_amount = $request->total;
            $order = $this->orderRepository->store_order($data_request);
            $payment_method = $this->payController->payOrder($total_amount);
            $order['redirect'] = $payment_method;
            if ($order)
                return response()->json(['status' => 'success', 'message' => 'Order Created Successfully', 'data' => $order]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function store_by_wallet(Request $request)
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
            'airport_id' => 'required',
            'status' => 'required|in:pending,processing,delivering,completed,cancelled,refunded',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'success', 'message' => 'Error Validation', 'errors' => $validator->errors()]);

        if (Auth::user()->balance < $request->total)
            return response()->json(['status' => 'success', 'message' => 'Wallet Balance Not Enough']);

        $data_request = $request->except(['image_front', 'image_back', 'image_ticket', 'image_passport']);
        $data_request['image_front'] = $this->uploadImage($request, 'image_front');
        $data_request['image_back'] = $this->uploadImage($request, 'image_back');
        $data_request['image_ticket'] = $this->uploadImage($request, 'image_ticket');
        $data_request['image_passport'] = $this->uploadImage($request, 'image_passport');
        $data_request['user_id'] = Auth::user()->id;
        try {
            $total_amount = $request->total;
            $order = $this->orderRepository->store_order($data_request);
            $user = Auth::user();
            $balance = $user['balance'] - $total_amount;
            $user->balance = $balance;
            $user->save();
            $NotificationClassTilte = " ! تم انشاء الاورد بنجاح ورقم الاوردر {$order->id}";
            $NotificationClassDesc = "تم انشاء الاوردر ب نجاح وهو ف ي الطريق اليك";
            $NotificationClass = NotificationClass::fcmPushNotification(Auth::user()->fcm_token, $NotificationClassTilte, $order, 'web');
            if ($NotificationClass) {
                NotificationData::create([
                    'sender_id' => 'Yone App',
                    'receiver_token' => Auth::user()->fcm_token,
                    'title' => $NotificationClassTilte,
                    'description' => $NotificationClassDesc,
                    'image' => '',
                    'action' => 'create_order',
                    'type' => 'create',
                    'platform' => 'web',
                ]);
            }
            if ($order)
                return response()->json(['status' => 'success', 'message' => 'Order Created Successfully', 'data' => $order]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function confirmPay($order_id)
    {
        $order = Order::find($order_id);
        if (!$order_id)
            return response()->json(['status' => 'error', 'message' => 'order not Found']);


        $confirmPay = Payment::where('order_id', $order_id)->first();
        if (!$confirmPay)
            return response()->json(['status' => 'error', 'message' => 'order not Found']);

        $confirmPay->status = 'completed';
        $confirmPay->save();
        $NotificationClassTilte = " ! تم انشاء الاورد بنجاح ورقم الاوردر {$order->id}";
        $NotificationClassDesc = "تم انشاء الاوردر ب نجاح وهو ف ي الطريق اليك";
        $NotificationClass = NotificationClass::fcmPushNotification(Auth::user()->fcm_token, $NotificationClassTilte, $order, 'web');
        if ($NotificationClass) {
            NotificationData::create([
                'sender_id' => 'Yone App',
                'receiver_token' => Auth::user()->fcm_token,
                'title' => $NotificationClassTilte,
                'description' => $NotificationClassDesc,
                'image' => '',
                'action' => 'create_order',
                'type' => 'create',
                'platform' => 'web',
            ]);
        }
        return response()->json(['status' => 'success', 'message' => 'Payment Order Completed', 'data' => $order]);
    }

    public function get_orders_by_user_id()
    {

        try {

            $orders = $this->orderRepository->get_orders_by_user_id();
            if (isset($orders) && count($orders) > 0)
                return response()->json(['status' => 'success', 'data' => $orders]);
            else
                return response()->json(['status' => 'success', 'data' => [], 'message' => 'Orders Not Found']);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    protected function uploadImage(Request $request, $image_name)
    {

        if (!$request->hasFile($image_name))
            return;

        $file = $request->file($image_name);
        return $file->store('uploads', 'public');

    }


}
