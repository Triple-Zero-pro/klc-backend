<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Models\Order;
use App\Repositories\AirportRepository as AirportRepository;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = [];
        $data['orders_competed'] = Order::where('status','completed')->get();
        $data['orders_competed'] = count($data['orders_competed']);

        $data['orders_pending'] = Order::where('status','pending')->get();
        $data['orders_pending'] = count($data['orders_pending']);

        $data['orders_cancelled'] = Order::where('status','cancelled')->get();
        $data['orders_cancelled'] = count($data['orders_cancelled']);
        $data['orders_total'] = Order::sum('total');
        $data['orders_map']  = Order::select('id', 'created_at', 'total')
            ->get()
            ->groupBy(function($date) {
                return Carbon::parse($date->created_at)->format('d');
            });


        try {
            if (isset($data) && count($data) > 0)
                return response()->json(['status' => 'success', 'data' => $data]);
            else
                return response()->json(['status' => 'success','data' => [], 'message' => 'Not Analytics Found']);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }



}
