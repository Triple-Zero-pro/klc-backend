<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Service;
use App\Repositories\ServiceRepository as ServiceRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServicesController extends Controller
{
    public $serviceRepository;


    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        $lang=$request->header('lang') ?? 'ar' ; app()->setLocale($lang);
        $category_id = 0;
        if ($request->category_id)
            $category_id = $request->category_id;
        try {
            $services = $this->serviceRepository->index($category_id);
            if (isset($services) && count($services) > 0)
                return response()->json(['status' => 'success', 'data' => $services]);
            else
                return response()->json(['status' => 'success','data' => [], 'message' => 'Not Services Found']);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function show(Request $request,$service_id)
    {
        $lang=$request->header('lang') ?? 'ar' ; app()->setLocale($lang);
        try {
            $service = $this->serviceRepository->show($service_id);
            if (isset($service))
                return response()->json(['status' => 'success', 'data' => $service]);
            else
                return response()->json(['status' => 'success','data' => '', 'message' => 'Not Services Found']);

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
            'description_en' => 'required|min:4',
            'terms_conditions_en' => 'required|min:4',
            'name_ar' => "required|string|min:3|max:191",
            'description_ar' => 'required|min:4',
            'terms_conditions_ar' => 'required|min:4',
            'category_id' => 'required|numeric',
            'image' => 'required',
            'price' => 'required|between:0,99.99',
            'status' => 'required|in:active,unactive',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        $data_request = $request->post();
        try {
            $service = $this->serviceRepository->store_service($data_request);
            if ($service)
                return response()->json(['status' => 'success', 'message' => 'Service Created Successfully', 'data' => $service]);

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


    public function update(Request $request, $id)
    {
        if (!$serve_check = $this->serviceRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Service ID Not Found',], 404);

        $validator = Validator::make($request->all(), [
            'name_en' => "required|string|min:3|max:191",
            'description_en' => 'required|min:4',
            'terms_conditions_en' => 'required|min:4',
            'name_ar' => "required|string|min:3|max:191",
            'description_ar' => 'required|min:4',
            'terms_conditions_ar' => 'required|min:4',
            'category_id' => 'required|numeric',
            'image' => 'required',
            'price' => 'required|between:0,99.99',
            'status' => 'required|in:active,unactive',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        $data_request = $request->post();
        try {
            $service = $this->serviceRepository->update_service($data_request, $id);
            if ($service)
                return response()->json(['status' => 'success', 'message' => 'Service Updated Successfully', 'data' => $service]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function destroy($id)
    {
        if (!$serve_check = $this->serviceRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Service ID Not Found',], 404);

        try {
            $service = $this->serviceRepository->destroy_service($id);
            return response()->json(['status' => 'success', 'message' => 'Service Deleted Successfully']);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function get_services_by_category($category_id)
    {

        try {
            if (!$category_check = Category::find($category_id))
                return response()->json(['status' => 'error', 'message' => 'Category ID Not Found',], 404);

            $services = $this->serviceRepository->get_services_by_category($category_id);
            if (isset($services) && count($services) > 0)
                return response()->json(['status' => 'success', 'data' => $services]);
            else
                return response()->json(['status' => 'success', 'message' => 'Services Not Found'], 404);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }
    public function get_services_by_name(Request $request,$service_name)
    {
        $lang = $request->header('lang') ?? 'ar' ; app()->setLocale($lang);
        $services = $this->serviceRepository->get_services_by_name($service_name,$lang);
        try {
            if (isset($services) && count($services) > 0)
                return response()->json(['status' => 'success', 'data' => $services]);
            else
                return response()->json(['status' => 'success', 'data' => [] ,'message' => 'Services Not Found'], 404);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


}
