<?php

namespace App\Http\Controllers;


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
        $lang=$request->header('lang') ?? 'ar' ; app()->setLocale($lang);
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
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
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
                    'data' => [],
                    'message' => 'Category ID Not  Found',
                ]);
            }
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }








}
