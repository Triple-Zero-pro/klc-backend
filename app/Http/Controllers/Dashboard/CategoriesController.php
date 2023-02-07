<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
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

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $categories = $this->categoryRepository->index();
            if (isset($categories) && count($categories) > 0) {
                return response()->json([
                    'status' => 'success',
                    'data' => $categories,
                ]);
            } else {
                return response()->json([
                    'status' => 'success','data' => [],
                    'message' => 'Not Categories Found',
                ], 404);
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
        $validator = Validator::make($request->all(), [
            'name_en' => "required|string|min:3|max:191",
            'name_ar' => "required|string|min:3|max:191",
            'status' => 'required|in:active,archived',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->uploadImage($request);
        try {
            $category = $this->categoryRepository->store_category($data_request);
            if ($category)
                return response()->json(['status' => 'success', 'message' => 'Category Created Successfully','data' => $category]);

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
    public function show(Request $request,$category_id): \Illuminate\Http\JsonResponse
    {
        $lang=$request->header('lang') ?? 'ar' ; app()->setLocale($lang);
        try {
            $category = $this->categoryRepository->show($category_id);
            if (isset($category)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $category,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'data' => '',
                    'message' => 'Category ID Not  Found',
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
        if (!$category_check = $this->categoryRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Category ID Not Found',], 404);

        $validator = Validator::make($request->all(), [
            'name_en' => "required|string|min:3|max:191",
            'name_ar' => "required|string|min:3|max:191",
            'status' => 'required|in:active,archived',
        ]);
        if ($validator->fails())
            return response()->json(['status' => 'error', 'message' => 'Error Validation', 'errors' => $validator->errors()], 406);


        $data_request = $request->except('image');
        if (isset($request->image))
            $data_request['image'] = $this->uploadImage($request);
        try {
            $category = $this->categoryRepository->update_category($data_request,$id);
            if ($category)
                return response()->json(['status' => 'success','message' => 'Category Updated Successfully', 'data' => $category]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function destroy(Request $request,$id)
    {
        if (!$category_check = $this->categoryRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Category ID Not Found',], 404);
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
