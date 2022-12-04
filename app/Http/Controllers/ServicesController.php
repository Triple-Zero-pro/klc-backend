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
                return response()->json(['status' => 'success','data' => [], 'message' => 'Not Services Found']);

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
                return response()->json(['status' => 'error', 'message' => 'Category ID Not Found'], 404);

            $services = $this->serviceRepository->get_services_by_category($category_id);
            if (isset($services) && count($services) > 0)
                return response()->json(['status' => 'success', 'data' => $services]);
            else
                return response()->json(['status' => 'success','data' => [] , 'message' => 'Services Not Found']);

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
                return response()->json(['status' => 'success', 'data' => [] ,'message' => 'Services Not Found']);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }



}
