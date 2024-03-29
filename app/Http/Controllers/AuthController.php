<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PayController as PayController;
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

class AuthController extends Controller
{
    //
    public $payController;

    public function __construct(PayController $payController)
    {
        $this->payController = $payController;
        $this->middleware('auth:api', ['except' => ['login', 'register', 'loginAdmin', 'apply_verification_code', 'update_password', 'send_verification_code']]);
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required|string',
        ]);
        $credentials = $request->only('phone', 'password');

        $token = Auth::attempt($credentials);
        if (!$token) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();
        $user['token'] = $token;
        return response()->json([
            'status' => 'success',
            'data' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);

    }

    public function loginAdmin(Request $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = auth()->guard('admins')->attempt($credentials)) {
                return response()->json(['success' => false, 'error' => 'Some Error Message'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['success' => false, 'error' => 'Failed to login, please try again.'], 500);
        }
        return $this->respondWithToken($token);
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
            // 'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|min:6|unique:users',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $user = User::create([
            'name' => $request->name,
            //'email' => $request->email,
            'phone' => $request->phone,
            'fcm_token' => $request->fcm_token,
            'password' => Hash::make($request->password),
        ]);

        $token = Auth::login($user);
        $user['token'] = $token;
        return response()->json([
            'status' => 'success',
            'message' => 'User created successfully',
            'data' => $user,
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
            $user = Auth::user();
            if ($user)
                return response()->json(['status' => 'success', 'message' => 'User Profile', 'data' => $user]);
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
            //'email' => 'required|string|email|max:255|unique:users',
            //'password' => 'required|string|min:6',
            //'phone' => 'required|string|min:6|unique:users',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        try {
            $user = Auth::user()->update([
                'name' => $request->name,
                // 'email' => $request->email,
                'email' => (isset($request->email) && $request->email != NULL) ? $request->email : Auth::user()->email,
                'phone' => (isset($request->phone) && $request->phone != NULL) ? $request->phone : Auth::user()->phone,
                'password' => (isset($request->password) && $request->password != NULL) ? Hash::make($request->password) : Auth::user()->getAuthPassword(),
            ]);
            if ($user)
                return response()->json(['status' => 'success', 'message' => 'User Updated Successfully', 'data' => Auth::user()]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function send_verification_code(Request $request)
    {
        $phone_check = User::where('phone', $request->phone)->first();
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
        $check_code = User::where([
            'phone' => $phone_number,
            'verification_code' => $request->verification_code,
        ])->first();
        if (!$check_code)
            return response()->json(['status' => 'error', 'message' => 'Phone Number Not Registered Check Phone Again',], 404);

        /*
                $validator = Validator::make($request->all(), [
                    'verification_code' => 'required',
                    'password' => 'required|string|min:6',
                    ]);

                if ($validator->fails())
                    return response()->json(['status' => 'success', 'message' => 'Error Validation', 'errors' => $validator->errors()]);*/

        try {
            /* $check_code->forceFill([
                 'password' =>  Hash::make($request->password),
                 'verification_code' =>  NULL,
             ])->save();*/
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
        $check_code = User::where([
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

    public function add_credit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_method' => 'required|string',
            'credit_number' => 'required|numeric|unique:user_credits',
            'credit_name' => 'required|string',
            'expired_date' => 'required',
            'cvv' => 'required|numeric',
        ]);

        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        try {
            $add_credit = UserCredit::create([
                'user_id' => Auth::user()->id,
                'payment_method' => $request->payment_method ?? NULL,
                'credit_number' => $request->credit_number,
                'credit_name' => $request->credit_name,
                'expired_date' => $request->expired_date,
                'cvv' => $request->cvv,
            ]);
            if ($add_credit)
                return response()->json(['status' => 'success', 'message' => 'Credit Card Added Successfully', 'data' => $add_credit]);

            return response()->json(['status' => 'error', 'message' => 'Something wrong Please Try Again'], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }

    }

    public function delete_credit($id)
    {
        $credit_check = UserCredit::where(['id' => $id, 'user_id' => Auth::user()->id])->first();

        if ($credit_check == false)
            return response()->json(['status' => 'error', 'message' => 'Credit ID Not Found',], 404);

        try {
            $credit_check = $credit_check->delete();
            if ($credit_check)
                return response()->json(['status' => 'success', 'message' => 'Credit Deleted Successfully']);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function all_credit()
    {
        try {
            $credits = UserCredit::where('user_id', Auth::user()->id)->get();

            if (isset($credits) && count($credits) > 0)
                return response()->json(['status' => 'success', 'data' => $credits]);

            return response()->json(['status' => 'status', 'data' => [], 'message' => 'Not Credits Found']);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function get_balance()
    {
        try {
            $balance = User::where('id', Auth::user()->id)->first();
            if (isset($balance))
                return response()->json(['status' => 'success', 'data' => $balance['balance']]);


        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function add_balance(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        try {
            $user = User::where('id', Auth::user()->id)->first();
            if ($user) {
                $total_amount = $request->amount;
                $payment_method = $this->payController->payOrder($total_amount);
                $user['redirect'] = $payment_method;
                return response()->json(['status' => 'success', 'message' => 'Balance Added Successfully', 'data' => $user]);
            }


        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function update_balance(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        try {
            $user = User::where('id', Auth::user()->id)->first();
            if ($user) {
                $user->balance += $request->amount;
                $user->save();
                return response()->json(['status' => 'success', 'message' => 'Balance Added Successfully', 'data' => $user]);
            }


        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function cancel_order($order_id)
    {
        $check_order = Order::where('id', $order_id)->where('user_id', Auth::user()->id)->first();
        if (!$check_order)
            return response()->json(['status' => 'error', 'data' => '', 'message' => 'Order Not Valid'], 404);
        try {
            $cancel_order = $check_order->update([
                'status' => 'cancelled',
            ]);
            if ($cancel_order)
                return response()->json(['status' => 'success', 'message' => 'Order Canceled Now ', 'data' => '']);

            return response()->json(['status' => 'error', 'message' => 'Something wrong Please Try Canceled Again'], 400);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }

    }

    public function notifications(): \Illuminate\Http\JsonResponse
    {
        $user = Auth::user();
        $notifications = NotificationData::where('receiver_token', $user->fcm_token)->get();
        return response()->json(['data' => $notifications, 'status' => 'success']);
    }


}
