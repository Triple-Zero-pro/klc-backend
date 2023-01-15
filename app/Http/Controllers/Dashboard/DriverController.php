<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DriverController extends Controller
{
    //
    public function drivers()
    {
        try {
            $drivers = Driver::paginate(15);
            if ($drivers)
                return response()->json(['status' => 'success', 'message' => 'Drivers', 'data' => $drivers]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something wrong Please Try Again'], 400);
        }
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


        try {
            $request->image = $this->uploadImage($request);
            $driver = Driver::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'image' => $request->image,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            if ($driver)
                return response()->json(['status' => 'success', 'message' => 'Driver Added Successfully', 'data' => $driver]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }



    public function profile($driver_id)
    {
        try {
            $driver = Driver::find($driver_id);
            if ($driver)
                return response()->json(['status' => 'success', 'message' => 'Driver Profile', 'data' => $driver]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }
    public function update(Request $request,$driver_id)
    {
        $driver = Driver::find($driver_id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'phone' => 'required|string|min:6|unique:drivers',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        $request->image = $this->uploadImage($request);
        try {
            $user = $driver->update([
                'name' => $request->name,
                'image' => $request->image,
                'email' => (isset($request->email) && $request->email != NULL) ? $request->email : $driver->email,
                'phone' => (isset($request->phone) && $request->phone != NULL) ? $request->phone : $driver->phone,
                'password' => (isset($request->password) && $request->password != NULL) ? Hash::make($request->password) : $driver->password,
            ]);
            if ($user)
                return response()->json(['status' => 'success', 'message' => 'Driver Updated Successfully', 'data' => $driver]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function update_status(Request $request,$driver_id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        try {
            $driver =  Driver::find($driver_id);
            $driver= $driver->update([
                'status' => $request->status
            ]);
            if ($driver)
                return response()->json(['status' => 'success', 'message' => 'Driver Status Updated Successfully', 'data' => $driver]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function get_orders_by_user_id($driver_id)
    {
        try {
            $orders = Order::where('driver_id', $driver_id)->get();
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

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image'))
            return;

        $file = $request->file('image');
        return $file->store('uploads', 'public');

    }

}
