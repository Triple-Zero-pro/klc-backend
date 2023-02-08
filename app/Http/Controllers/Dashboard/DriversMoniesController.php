<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Repositories\DriversMoneyRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DriversMoniesController extends Controller
{
    public $driversMoneyRepository;


    public function __construct(DriversMoneyRepository $driversMoneyRepository)
    {
        $this->driversMoneyRepository = $driversMoneyRepository;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
           $driversMonies = $this->driversMoneyRepository->index();
            if (isset($driversMonies) && count($driversMonies) > 0) {
                return response()->json([
                    'status' => 'success',
                    'data' => $driversMonies,
                ]);
            } else {
                return response()->json([
                    'status' => 'success', 'data' => [],
                    'message' => 'Not Drivers Moneys Found',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function show($DriversMoney_id): \Illuminate\Http\JsonResponse
    {
        try {
            $DriversMoney = $this->driversMoneyRepository->show($DriversMoney_id);
            if (isset($DriversMoney)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $DriversMoney,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'data' => [],
                    'message' => 'Drivers Money ID Not  Found',
                ]);
            }
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
            'driver_id' => "required",
            'amount' => "required|min:1|max:191",
            'type' => 'required|in:petrol,salary',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $data_request = $request->post();
        try {
            $DriversMoney = $this->driversMoneyRepository->store_DriversMoney($data_request);
            if ($DriversMoney)
                return response()->json(['status' => 'success', 'message' => 'Drivers Money Created Successfully', 'data' => $DriversMoney]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }
    public function statistics()
    {
        try {
            $data = $this->driversMoneyRepository->statistics();
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
