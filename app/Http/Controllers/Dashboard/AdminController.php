<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Order;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    public function admins()
    {
        try {
            $admins = Admin::paginate(15);
            if ($admins)
                return response()->json(['status' => 'success', 'message' => 'Admins', 'data' => $admins]);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something wrong Please Try Again'], 400);
        }
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique:drivers',
            'phone_number' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        try {
            $request->image = $this->uploadImage($request);
            $admin = Admin::create([
                'username' => $request->name.time(),
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'image' => $request->image,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            if ($admin)
                return response()->json(['status' => 'success', 'message' => 'Admin Added Successfully', 'data' => $admin]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }



    public function profile($admin_id)
    {
        try {
            $admin = Admin::find($admin_id);
            if ($admin)
                return response()->json(['status' => 'success', 'message' => 'Admin Profile', 'data' => $admin]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }
    public function update(Request $request,$admin_id)
    {
        $admin = Admin::find($admin_id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        $request->image = $this->uploadImage($request);
        try {
            $user = $admin->update([
                'username' => $request->name.time(),
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'image' => $request->image,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            if ($user)
                return response()->json(['status' => 'success', 'message' => 'Admin Updated Successfully', 'data' => $admin]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function update_status(Request $request,$admin_id)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        try {
            $admin =  Admin::find($admin_id);
            $admin= $admin->update([
                'status' => $request->status
            ]);
            if ($admin)
                return response()->json(['status' => 'success', 'message' => 'Admin Status Updated Successfully', 'data' => $admin]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function get_orders_by_user_id($admin_id)
    {
        try {
            $orders = Order::where('admin_id', $admin_id)->get();
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
