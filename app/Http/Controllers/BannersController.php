<?php

namespace App\Http\Controllers;


use App\Models\Banner;
use App\Repositories\BannerRepository as BannerRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannersController extends Controller
{
    public $bannerRepository;


    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $banners = $this->bannerRepository->index();
            if (isset($banners) && count($banners) > 0)
                return response()->json(['status' => 'success', 'data' => $banners]);

            else
                return response()->json(['status' => 'success', 'data' => [], 'message' => 'Not Banners Found',]);

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
            'image' => 'required',
            'target' => 'required',
            'banner_type_id' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $data_request = $request->except('image');
        $data_request['image'] = $this->uploadImage($request);
        try {
            $banner = $this->bannerRepository->store_banner($data_request);
            if ($banner)
                return response()->json(['status' => 'success', 'message' => 'Banner Created Successfully', 'data' => $banner]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function show(Request $request, $banner_id): \Illuminate\Http\JsonResponse
    {
        try {
            $banner = $this->bannerRepository->show($banner_id);
            if (isset($banner))
                return response()->json(['status' => 'success', 'data' => $banner]);
            else
                return response()->json(['status' => 'error', 'data' => [], 'message' => 'Banner ID Not  Found']);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something wrong Please Try Again'], 400);
        }
    }


    public function update(Request $request, $id)
    {
        if (!$banner_check = $this->bannerRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Banner ID Not Found',], 404);

        $validator = Validator::make($request->all(), [
            'image' => 'required',
            'target' => 'required',
            'banner_type_id' => 'required',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $data_request = $request->except('image');
        $data_request['image'] = $this->uploadImage($request);
        try {
            $banner = $this->bannerRepository->update_banner($data_request, $id);
            if ($banner)
                return response()->json(['status' => 'success', 'message' => 'Banner Updated Successfully', 'data' => $banner]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function destroy(Request $request, $id)
    {
        if (!$banner_check = $this->bannerRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Banner ID Not Found',], 404);
        try {
            $banner = $this->bannerRepository->destroy_banner($id);
            return response()->json(['status' => 'success', 'message' => 'Banner Deleted Successfully']);
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
