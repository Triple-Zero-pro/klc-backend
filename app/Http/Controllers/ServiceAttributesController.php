<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Models\Service;
use App\Models\ServiceAttribute;
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

    public function index(Request $request, $service_id): \Illuminate\Http\JsonResponse
    {
        $lang = $request->header('lang') ?? 'ar';
        app()->setLocale($lang);
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
            'title_en' => "required|string|min:3|max:191",
            'title_ar' => "required|string|min:3|max:191",
            'input_name' => 'required|string|min:4',
            'input_type' => 'required|string|min:4|in:text,file',
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


    public function destroy($service_attributes_id)
    {
        if (!$service_attributes = $this->serviceAttributeRepository->show($service_attributes_id))
            return response()->json(['status' => 'error', 'message' => 'Service Attribute ID Not Found',], 404);

        try {
            $serviceAttribute = $this->serviceAttributeRepository->destroy_serviceAttribute($service_attributes_id);
            return response()->json(['status' => 'success', 'message' => 'ServiceAttribute Deleted Successfully']);
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something wrong Please Try Again',], 400);
        }
    }


}
