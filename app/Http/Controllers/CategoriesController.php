<?php

namespace App\Http\Controllers;


use App\Repositories\CategoryRepository as CategoryRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => "required|string|min:3|max:191",
            'image' => 'required',
            'status' => 'required|in:active,archived',
        ]);
        if($validator->fails())
            return response()->json(['status' => 'error','message' => 'Error Validation', 'errors' => $validator->errors()],402);

        $data_request = $request->post();
        try {
            $category = $this->categoryRepository->store_category($data_request);
            if ($category)
                return response()->json(['status' => 'success', 'category' => $category,]);

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


    public function destroy($id)
    {
        try {
            $category = $this->categoryRepository->destroy_category($id);
            return response()->json(['status' => 'success', 'message' => 'Category Deleted Successfully']);
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
