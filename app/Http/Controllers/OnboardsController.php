<?php

namespace App\Http\Controllers;


use App\Models\AboutUs;
use App\Models\Onboard;
use App\Repositories\OnboardRepository as OnboardRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OnboardsController extends Controller
{
    public $onboardRepository;


    public function __construct(OnboardRepository $onboardRepository)
    {
        $this->onboardRepository = $onboardRepository;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $lang=$request->header('lang') ?? 'ar' ; app()->setLocale($lang);
        try {
            $onboards = $this->onboardRepository->index();
            if (isset($onboards) && count($onboards) > 0)
                return response()->json(['status' => 'success', 'data' => $onboards,]);
            else
                return response()->json(['data' => '', 'message' => 'Not Onboards Found',], 404);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function show(Request $request, $onboard_id): \Illuminate\Http\JsonResponse
    {
        $lang=$request->header('lang') ?? 'ar' ; app()->setLocale($lang);
        try {
            $onboard = $this->onboardRepository->show($onboard_id);
            if (isset($onboard)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $onboard,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'data' => '',
                    'message' => 'Onboard ID Not  Found',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }
    public function about_us(Request $request)
    {
        $lang=$request->header('lang') ?? 'ar' ; app()->setLocale($lang);
        try {
            $about_us = AboutUs::find(1);
            if (isset($about_us)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $about_us,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'data' => '',
                    'message' => 'About US Not  Found',
                ], 404);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }

    }

}
