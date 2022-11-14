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

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $services = $this->serviceRepository->index();
            if (isset($services) && count($services) > 0)
                return response()->json(['status' => 'success', 'data' => $services]);
            else
                return response()->json(['data' => '', 'message' => 'Not Services Found',], 404);

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
    public function show($service_id)
    {
        try {
            $service = $this->serviceRepository->show($service_id);
            if (isset($service))
                return response()->json(['status' => 'success', 'data' => $service]);
            else
                return response()->json(['data' => '', 'message' => 'Not Services Found',], 404);

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
            'name' => "required|string|min:3|max:191",
            'category_id' => 'required|int',
            'image' => 'required',
            'description' => 'required|min:4',
            'terms_conditions' => 'required|min:4',
            'price' => 'required|between:0,99.99',
            'status' => 'required|in:active,archived',
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
        $validator = Validator::make($request->all(), [
            'name' => "required|string|min:3|max:191",
            'category_id' => 'required|int',
            'image' => 'required',
            'description' => 'required|min:4',
            'terms_conditions' => 'required|min:4',
            'price' => 'required|between:0,99.99',
            'status' => 'required|in:active,archived',
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
        if (!$serve_check = Service::find($id))
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
                return response()->json(['status' => 'error', 'message' => 'Services Not Found'], 404);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


}