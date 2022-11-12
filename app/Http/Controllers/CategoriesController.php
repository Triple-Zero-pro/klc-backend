<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest as CategoryRequest;
use App\Repositories\CategoryRepository as CategoryRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class CategoriesController extends Controller
{
    public $categoryRepository;


    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(): \Illuminate\Http\JsonResponse
    {
        try {
            $categories = $this->categoryRepository->index();
            if (isset($categories) && count($categories) > 0) {
                return response()->json([
                    'status' => 'success',
                    'categories' => $categories,
                ]);
            } else {
                return response()->json([
                    'status' => '',
                    'categories' => 0,
                    'message' => 'Not Categories Found',
                ], 204);
            }
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

    public function store(CategoryRequest $request)
    {
        $request->merge(['slug' => Str::slug($request->name)]);
        $data_request = $request->except('image');
        $data_request['image'] = $this->uploadImage($request);
        try {
            $category = $this->categoryRepository->store_category($data_request);
            if ($category)
            {
                return response()->json([
                    'status' => 'success',
                    'category' => $category,
                ]);
            }

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


    public function update(CategoryRequest $request, $id)
    {

    }


    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        try {
            $category = $this->categoryRepository->destroy_category($id);
            if ($category)
                return response()->json(['status' => 'success', 'message' => 'Category Deleted Successfully',]);
            else
                return response()->json(['status' => 'error', 'message' => 'Category Not Found'], 204);
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
