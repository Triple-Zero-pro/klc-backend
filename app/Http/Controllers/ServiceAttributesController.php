<?php

namespace App\Http\Controllers;


use App\Models\Service;
use App\Repositories\ServiceAttributeRepository as ServiceAttributeRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ServiceAttributesController extends Controller
{
    public $serviceAttributeRepository;


    public function __construct(ServiceAttributeRepository $serviceAttributeRepository)
    {
        $this->serviceAttributeRepository = $serviceAttributeRepository;
    }

    public function index($service_id): \Illuminate\Http\JsonResponse
    {
        if (!$check_service = Service::find($service_id))
            return response()->json(['status' => 'error', 'message' => 'Service ID Not Found',], 404);

        try {
            $serviceAttributes = $this->serviceAttributeRepository->index($service_id);
            if (isset($serviceAttributes) && count($serviceAttributes) > 0)
                return response()->json(['status' => 'success', 'data' => $serviceAttributes]);
            else
                return response()->json(['status' => 'success', 'data' => [], 'message' => 'Not Service Attributes Found',], 404);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error', 'message' => 'Something wrong Please Try Again',], 400);
        }
    }

    public function store(Request $request, $service_id)
    {
        if (!$check_service = Service::find($service_id))
            return response()->json(['status' => 'error', 'message' => 'Service ID Not Found',], 404);

        $validator = Validator::make($request->all(), [
            'from' => "required",
            'to' => "required",
            'appointment_date' => "required",
            'appointment_time' => "required",
            'images' => "required",
            'gender' => "required",
            'embassy' => "required",
            'select_service' => "required",
            'employee_status' => "required",
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);

        $data_request = $request->post();
        $data_request['service_id'] = $service_id;
        try {
            $serviceAttribute = $this->serviceAttributeRepository->store_serviceAttribute($data_request);
            if ($serviceAttribute)
                return response()->json(['status' => 'success', 'message' => 'Service Attribute Created Successfully', 'data' => $serviceAttribute]);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something wrong Please Try Again',], 400);
        }
    }


}
