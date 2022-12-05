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
                return response()->json(['status' => 'success','data' => [], 'message' => 'Not Clients Found']);

        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Something wrong Please Try Again'], 400);
        }
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
