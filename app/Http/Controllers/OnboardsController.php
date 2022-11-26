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

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_en' => "required|string|min:3|max:191",
            'title_ar' => "required|string|min:3|max:191",
            'image' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        $data_request = $request->post();
        try {
            $onboard = $this->onboardRepository->store_onboard($data_request);
            if ($onboard)
                return response()->json(['status' => 'success', 'message' => 'Onboard Created Successfully', 'data' => $onboard]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function edit($id)
    {

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


    public function update(Request $request, $id)
    {
        if (!$onboard_check = $this->onboardRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Onboard ID Not Found',], 404);

        $validator = Validator::make($request->all(), [
            'title_en' => "required|string|min:3|max:191",
            'title_ar' => "required|string|min:3|max:191",
            'image' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        $data_request = $request->post();
        try {
            $onboard = $this->onboardRepository->update_onboard($data_request, $id);
            if ($onboard)
                return response()->json(['status' => 'success', 'message' => 'Onboard Updated Successfully', 'data' => $onboard]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function destroy(Request $request, $id)
    {
        if (!$onboard_check = $this->onboardRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Onboard ID Not Found',], 404);
        try {
            $onboard = $this->onboardRepository->destroy_onboard($id);
            return response()->json(['status' => 'success', 'message' => 'Onboard Deleted Successfully']);
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

    public function about_us_update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'logo' => 'required',
            'phone' => 'required',
            'location' => 'required',
            'linkedin' => 'required',
            'facebook' => 'required',
            'twitter' => 'required',
            'address_ar' => "required|string|min:3",
            'address_en' => "required|string|min:3",
            'aboutUs_ar' => "required|string|min:3",
            'aboutUs_en' => "required|string|min:3",
            'terms_condition_ar' => "required|string|min:3",
            'terms_condition_en' => "required|string|min:3",
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        try {
            $about_us = AboutUs::UpdateOrCreate([
                'id' => 1,
                'logo' => $request->logo,
                'phone' => $request->phone,
                'location' => $request->location,
                'linkedin' => $request->linkedin,
                'facebook' => $request->facebook,
                'twitter' => $request->twitter,
                'address_ar' => $request->address_ar,
                'address_en' => $request->address_en,
                'aboutUs_ar' => $request->aboutUs_ar,
                'aboutUs_en' => $request->aboutUs_en,
                'terms_condition_ar' => $request->terms_condition_ar,
                'terms_condition_en' => $request->terms_condition_en,
            ]);
            if ($about_us)
                return response()->json(['status' => 'success', 'message' => 'About Us Updated Successfully', 'data' => $about_us]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

}
