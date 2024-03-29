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
            $clients = $this->clientRepository->index($request);
            if (isset($clients))
                return response()->json(['status' => 'success', 'data' => $clients]);
            else
                return response()->json(['status' => 'success', 'data' => [], 'message' => 'Not Clients Found']);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something wrong Please Try Again'], 400);
        }
    }

    public function show(Request $request, $client_id): \Illuminate\Http\JsonResponse
    {

        try {
            $client = $this->clientRepository->show($client_id);
            if (isset($client))
                return response()->json(['status' => 'success', 'data' => $client]);
            else
                return response()->json(['status' => 'success', 'data' => [], 'message' => 'Client ID Not  Found']);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }



    public function update(Request $request, $id)
    {
        if (!$category_check = $this->clientRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Client ID Not Found',], 404);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'phone' => 'required|string|min:6',
            'status' => 'required|in:active,inactive',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $data_request = $request->except(['image_front','image_back','image']);
        if (isset($request->image))
            $data_request['image'] = $this->uploadImage($request,'image');

        if (isset($request->image_front))
            $data_request['image_front'] = $this->uploadImage($request,'image_front');

        if (isset($request->image_back))
            $data_request['image_back'] = $this->uploadImage($request,'image_back');
        try {
            $category = $this->clientRepository->update_client($data_request, $id);
            if ($category)
                return response()->json(['status' => 'success', 'message' => 'Client Updated Successfully', 'data' => $category]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function destroy(Request $request, $id)
    {
        if (!$client_check = $this->clientRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Client ID Not Found'], 404);
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


    public function client_orders($client_id): \Illuminate\Http\JsonResponse
    {
        try {
            $orders = $this->clientRepository->client_orders($client_id);
            if (isset($orders) && count($orders) > 0)
                return response()->json(['status' => 'success', 'data' => $orders]);
            else
                return response()->json(['status' => 'success', 'data' => [], 'message' => 'Not Orders Found']);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something wrong Please Try Again'], 400);
        }
    }
    public function client_banned($client_id)
    {
        if (!$client_check = $this->clientRepository->show($client_id))
            return response()->json(['status' => 'error', 'message' => 'Client ID Not Found'], 404);

        try {
            $order = $this->clientRepository->client_banned($client_id);
            if ($order)
                return response()->json(['status' => 'success', 'message' => 'Client Banned Successfully', 'data' => $order]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }
    public function client_active($client_id)
    {
        if (!$client_check = $this->clientRepository->show($client_id))
            return response()->json(['status' => 'error', 'message' => 'Client ID Not Found'], 404);

        try {
            $client = $this->clientRepository->client_active($client_id);
            $client_check = $this->clientRepository->client_active($client_id);
            if ($client)
                return response()->json(['status' => 'success', 'message' => 'Client Active Successfully', 'data' => $client_check]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    protected function uploadImage(Request $request,$image_name)
    {

        if (!$request->hasFile($image_name))
            return;

        $file = $request->file($image_name);
        return $file->store('uploads', 'public');

    }

}
