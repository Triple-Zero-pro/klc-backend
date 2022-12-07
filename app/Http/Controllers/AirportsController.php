<?php

namespace App\Http\Controllers;


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

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $lang=$request->header('lang') ?? 'ar' ; app()->setLocale($lang);
        try {
            $airports = $this->airportRepository->index();
            if (isset($airports) && count($airports) > 0) {
                return response()->json([
                    'status' => 'success',
                    'data' => $airports,
                ]);
            } else {
                return response()->json([
                    'status' => 'success','data' => [],
                    'message' => 'Not Categories Found',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }



    public function show(Request $request,$airport_id): \Illuminate\Http\JsonResponse
    {
        $lang=$request->header('lang') ?? 'ar' ; app()->setLocale($lang);
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








}
