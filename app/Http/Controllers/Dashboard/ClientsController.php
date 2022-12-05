<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\ClientRepository as ClientRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ClientsController extends Controller
{
    public $clientRepository;


    public function __construct(ClientRepository $clientRepository)
    {
        $this->clientRepository = $clientRepository;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $clients = $this->clientRepository->index();
            if (isset($clients) && count($clients) > 0)
                return response()->json(['status' => 'success', 'data' => $clients]);
            else
                return response()->json(['status' => 'success','data' => [], 'message' => 'Not Categories Found']);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something wrong Please Try Again'], 400);
        }
    }

    public function create()
    {

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_en' => "required|string|min:3|max:191",
            'name_ar' => "required|string|min:3|max:191",
            'image' => 'required',
            'status' => 'required|in:active,archived',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $data_request = $request->except('image');
        $data_request['image'] = $this->uploadImage($request);
        try {
            $client = $this->clientRepository->store_client($data_request);
            if ($client)
                return response()->json(['status' => 'success', 'message' => 'Client Created Successfully','data' => $client]);

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
    public function show(Request $request,$client_id): \Illuminate\Http\JsonResponse
    {
        $lang=$request->header('lang') ?? 'ar' ; app()->setLocale($lang);
        try {
            $client = $this->clientRepository->show($client_id);
            if (isset($client)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $client,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'data' => '',
                    'message' => 'Client ID Not  Found',
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
        if (!$client_check = $this->clientRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Client ID Not Found',], 404);

        $validator = Validator::make($request->all(), [
            'name_en' => "required|string|min:3|max:191",
            'name_ar' => "required|string|min:3|max:191",
            'status' => 'required|in:active,archived',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $data_request = $request->except('image');
        $data_request['image'] = $this->uploadImage($request);
        try {
            $client = $this->clientRepository->update_client($data_request,$id);
            if ($client)
                return response()->json(['status' => 'success','message' => 'Client Updated Successfully', 'data' => $client]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function destroy(Request $request,$id)
    {
        if (!$client_check = $this->clientRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Client ID Not Found',], 404);
        try {
            $client = $this->clientRepository->destroy_client($id);
            return response()->json(['status' => 'success', 'message' => 'Client Deleted Successfully']);
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
