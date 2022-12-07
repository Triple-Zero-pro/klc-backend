<?php

namespace App\Http\Controllers\Dashboard;


use App\Http\Controllers\Controller;
use App\Models\Airport;
use App\Repositories\AirportRepository as AirportRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AirportsController extends Controller
{
    public $airportRepository;


    public function __construct(AirportRepository $airportRepository)
    {
        $this->airportRepository = $airportRepository;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $airports = $this->airportRepository->index();
            if (isset($airports) && count($airports) > 0) {
                return response()->json([
                    'status' => 'success',
                    'data' => $airports,
                ]);
            } else {
                return response()->json([
                    'status' => 'success', 'data' => [],
                    'message' => 'Not Airports Found',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function show($airport_id): \Illuminate\Http\JsonResponse
    {
        try {
            $airport = $this->airportRepository->show($airport_id);
            if (isset($airport)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $airport,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'data' => [],
                    'message' => 'Airport ID Not  Found',
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
            'name_en' => "required|string|min:3|max:191",
            'name_ar' => "required|string|min:3|max:191",
            'status' => 'required|in:active,archived',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $data_request = $request->post();
        try {
            $airport = $this->airportRepository->store_airport($data_request);
            if ($airport)
                return response()->json(['status' => 'success', 'message' => 'Airport Created Successfully', 'data' => $airport]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function update(Request $request, $id)
    {
        if (!$airport_check = $this->airportRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Airport ID Not Found',], 404);

        $validator = Validator::make($request->all(), [
            'name_en' => "required|string|min:3|max:191",
            'name_ar' => "required|string|min:3|max:191",
            'status' => 'required|in:active,archived',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $data_request = $request->post();
        try {
            $airport = $this->airportRepository->update_airport($data_request, $id);
            if ($airport)
                return response()->json(['status' => 'success', 'message' => 'Airport Updated Successfully', 'data' => $airport]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function destroy(Request $request, $id)
    {
        if (!$airport_check = $this->airportRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Airport ID Not Found'], 404);
        try {
            $airport = $this->airportRepository->destroy_airport($id);
            return response()->json(['status' => 'success', 'message' => 'Airport Deleted Successfully']);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


}
