<?php

namespace App\Http\Controllers;


use App\Models\BannerType;
use App\Repositories\BannerTypeRepository as BannerTypeRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerTypesController extends Controller
{
    public $bannerTypeRepository;


    public function __construct(BannerTypeRepository $bannerTypeRepository)
    {
        $this->bannerTypeRepository = $bannerTypeRepository;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $bannerTypes = $this->bannerTypeRepository->index();
            if (isset($bannerTypes) && count($bannerTypes) > 0)
                return response()->json(['status' => 'success', 'data' => $bannerTypes]);

            else
                return response()->json(['status' => 'success', 'data' => [], 'message' => 'Not BannerTypes Found',]);

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
            'name' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $data_request = $request->post();
        try {
            $bannerType = $this->bannerTypeRepository->store_bannerType($data_request);
            if ($bannerType)
                return response()->json(['status' => 'success', 'message' => 'BannerType Created Successfully', 'data' => $bannerType]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function show(Request $request, $bannerType_id): \Illuminate\Http\JsonResponse
    {
        try {
            $bannerType = $this->bannerTypeRepository->show($bannerType_id);
            if (isset($bannerType))
                return response()->json(['status' => 'success', 'data' => $bannerType]);
            else
                return response()->json(['status' => 'error', 'data' => [], 'message' => 'BannerType ID Not  Found']);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something wrong Please Try Again'], 400);
        }
    }


    public function update(Request $request, $id)
    {
        if (!$bannerType_check = $this->bannerTypeRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'BannerType ID Not Found',], 404);

        $validator = Validator::make($request->all(), [
            'name' => 'required',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $data_request = $request->post();
        try {
            $bannerType = $this->bannerTypeRepository->update_bannerType($data_request, $id);
            if ($bannerType)
                return response()->json(['status' => 'success', 'message' => 'BannerType Updated Successfully', 'data' => $bannerType]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function destroy(Request $request, $id)
    {
        if (!$bannerType_check = $this->bannerTypeRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'BannerType ID Not Found',], 404);
        try {
            $bannerType = $this->bannerTypeRepository->destroy_bannerType($id);
            return response()->json(['status' => 'success', 'message' => 'BannerType Deleted Successfully']);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


}
