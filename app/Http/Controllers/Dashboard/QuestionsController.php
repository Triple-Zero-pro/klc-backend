<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Repositories\QuestionRepository as QuestionRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class QuestionsController extends Controller
{
    public $questionRepository;


    public function __construct(QuestionRepository $questionRepository)
    {
        $this->questionRepository = $questionRepository;
    }

    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try {
            $questions = $this->questionRepository->index();
            if (isset($questions) && count($questions) > 0) {
                return response()->json([
                    'status' => 'success',
                    'data' => $questions,
                ]);
            } else {
                return response()->json([
                    'status' => 'success','data' => [],
                    'message' => 'Not Questions Found',
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
            $question = $this->questionRepository->store_question($data_request);
            if ($question)
                return response()->json(['status' => 'success', 'message' => 'Question Created Successfully','data' => $question]);

        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }

    public function show(Request $request,$question_id): \Illuminate\Http\JsonResponse
    {
        $lang=$request->header('lang') ?? 'ar' ; app()->setLocale($lang);
        try {
            $question = $this->questionRepository->show($question_id);
            if (isset($question)) {
                return response()->json([
                    'status' => 'success',
                    'data' => $question,
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'data' => '',
                    'message' => 'Question ID Not  Found',
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
        if (!$question_check = $this->questionRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Question ID Not Found',], 404);

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
            $question = $this->questionRepository->update_question($data_request,$id);
            if ($question)
                return response()->json(['status' => 'success','message' => 'Question Updated Successfully', 'data' => $question]);
        } catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Something wrong Please Try Again',
            ], 400);
        }
    }


    public function destroy(Request $request,$id)
    {
        if (!$question_check = $this->questionRepository->show($id))
            return response()->json(['status' => 'error', 'message' => 'Question ID Not Found',], 404);
        try {
            $question = $this->questionRepository->destroy_question($id);
            return response()->json(['status' => 'success', 'message' => 'Question Deleted Successfully']);
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
