<?php

namespace App\Http\Controllers\Driver;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\NotificationData;
use App\Models\Order;
use App\Models\User;
use App\Models\UserCredit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth:drivers', ['except' => ['login', 'register', 'apply_verification_code', 'update_password', 'send_verification_code']]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('phone', 'password');
        try {
            if (!$token = auth()->guard('drivers')->attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'Some Error Message'], 401);
            }
            $user = auth()->guard('drivers')->user();
            $user['token'] = $token;
            return response()->json(['status' => 'success', 'data' => $user, 'authorisation' => ['token' => $token, 'type' => 'bearer']]);
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }


    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|min:6|unique:drivers',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $driver = Driver::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'fcm_token'=> $request->fcm_token,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($driver);
        $driver['token'] = $token;
        return response()->json([
            'status' => 'success',
            'message' => 'Driver created successfully',
            'data' => $driver,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'success',
            'message' => 'Successfully logged out',
        ]);
    }

    public function refresh()
    {
        return response()->json([
            'status' => 'success',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }

    public function profile()
    {
        try {
            $driver = Auth::user();
            if ($driver)
                return response()->json(['status' => 'success', 'message' => 'Driver Profile', 'data' => $driver]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        $request->image = $this->uploadImage($request);
        try {
            $user = Auth::user()->update([
                'name' => $request->name,
                'image' => $request->image,
                'email' => (isset($request->email) && $request->email != NULL) ? $request->email : Auth::user()->email,
                'phone' => (isset($request->phone) && $request->phone != NULL) ? $request->phone : Auth::user()->phone,
                'password' => (isset($request->password) && $request->password != NULL) ? Hash::make($request->password) : Auth::user()->getAuthPassword(),
            ]);
            if ($user)
                return response()->json(['status' => 'success', 'message' => 'Driver Updated Successfully', 'data' => Auth::user()]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function update_status(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        try {
            $driver =  Auth::user();
            $driver= $driver->update([
                'status' => $request->status
            ]);
            $driver =  Auth::user();
            if ($driver)
                return response()->json(['status' => 'success', 'message' => 'Driver Status Updated Successfully', 'data' => $driver]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function update_location(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'lat' => 'required',
            'long' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        try {
            $driver =  Auth::user();
            $driver= $driver->update([
                'lat' => $request->lat,
                'long' => $request->long
            ]);
            $driver =  Auth::user();
            if ($driver)
                return response()->json(['status' => 'success', 'message' => 'Driver Location Updated Successfully', 'data' => $driver]);
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
            $orders = Order::where('driver_id', Auth::user()->id)->with('airport')->get();
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
    public function get_orders_by_driver_status($driver_status)
    {
        try {
            $orders = Order::where('driver_id', Auth::user()->id)->where('driver_status', $driver_status)->with('airport')->get();
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

    public function accepted(Request $request, $id)
    {
        if (!$order_check = Order::where('id', $id)->where('driver_id', Auth::user()->id)->with('airport')->first())
            return response()->json(['status' => 'error', 'message' => 'Order ID Not Found',], 404);

        try {
            $order = $order_check;
            $order_check->driver_status = 'accepted';
            if ($order_check->save())
                return response()->json(['status' => 'success', 'message' => 'Order Updated Successfully', 'data' => $order]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function refused(Request $request, $id)
    {
        if (!$order_check = Order::where('id', $id)->where('driver_id', Auth::user()->id)->first())
            return response()->json(['status' => 'error', 'message' => 'Order ID Not Found',], 404);

        try {
            $order = $order_check;
            $order_check->driver_status = 'refused';
            if ($order_check->save())
                return response()->json(['status' => 'success', 'message' => 'Order Updated Successfully', 'data' => $order]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }
    public function servant_delivered(Request $request, $id)
    {
        if (!$order_check = Order::where('id', $id)->where('driver_id', Auth::user()->id)->first())
            return response()->json(['status' => 'error', 'message' => 'Order ID Not Found',], 404);

        try {
            $order = $order_check;
            $order_check->driver_status = 'servant_delivered';
            if ($order_check->save())
                return response()->json(['status' => 'success', 'message' => 'Order Updated Successfully', 'data' => $order]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function servant_delivering(Request $request, $id)
    {
        if (!$order_check = Order::where('id', $id)->where('driver_id', Auth::user()->id)->with('airport')->first())
            return response()->json(['status' => 'error', 'message' => 'Order ID Not Found',], 404);

        try {
            $order = $order_check;
            $order_check->driver_status = 'servant_delivering';
            if ($order_check->save())
                return response()->json(['status' => 'success', 'message' => 'Order Updated Successfully', 'data' => $order]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function send_verification_code(Request $request)
    {
        $phone_check = Driver::where('phone', $request->phone)->first();
        if (!$phone_check)
            return response()->json(['status' => 'error', 'message' => 'Phone Number Not Registered Check Phone Again'], 404);

        $validator = Validator::make($request->all(), [
            'phone' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        try {
            $verification_code = mt_rand(100000, 999999);
            $phone_check->forceFill([
                'verification_code' => $verification_code
            ])->save();
            $message = "Your Verification Code to Reset Password is " . $verification_code . "  ";
            $gateway = config('twilio');
            //Sms::driver($gateway)->sendSms($request->phone,$message);
            return response()->json(['status' => 'success', 'message' => $message, 'data' => $verification_code]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }

    }

    public function apply_verification_code(Request $request, $phone_number)
    {
        $check_code = Driver::where([
            'phone' => $phone_number,
            'verification_code' => $request->verification_code,
        ])->first();
        if (!$check_code)
            return response()->json(['status' => 'error', 'message' => 'Phone Number Not Registered Check Phone Again',], 404);

        try {
            return response()->json(['status' => 'success', 'message' => 'Verification Code Is Valid', 'data' => []]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }

    }

    public function update_password(Request $request, $phone_number)
    {
        $check_code = Driver::where([
            'phone' => $phone_number,
            'verification_code' => $request->verification_code,
        ])->first();
        if (!$check_code)
            return response()->json(['status' => 'error', 'message' => 'Phone Number Not Registered Check Phone Again',], 404);


        $validator = Validator::make($request->all(), [
            'verification_code' => 'required',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails())
            return response()->json(['status' => 'success', 'message' => 'Error Validation', 'errors' => $validator->errors()]);

        try {
            $check_code->forceFill([
                'password' => Hash::make($request->password),
                'verification_code' => NULL,
            ])->save();
            return response()->json(['status' => 'success', 'message' => 'Password Updated Successfully', 'data' => $check_code]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }

    }
    public  function notifications(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $notifications = NotificationData::where('receiver_token',$user->fcm_token)->get();
        return response()->json(['data' => $notifications , 'status' => 'success']);
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image'))
            return;

        $file = $request->file('image');
        return $file->store('uploads', 'public');

    }

}
