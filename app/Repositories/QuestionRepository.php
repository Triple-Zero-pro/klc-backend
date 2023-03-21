<?php


namespace App\Repositories;

use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Eloquent\BaseRepository;


class QuestionRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */


    public function index()
    {
        return $this->model->all();
    }


    public function show($id)
    {
        return $this->model->find($id);
    }



    public function store_question($data_request)
    {
        return $this->model->create($data_request);

    }


    public function update_question($data_request, $id)
    {
        $question = $this->model->find($id);
        $question->update($data_request);
        return $question;

    }


    public function destroy_question($id)
    {
        $question = $this->model->find($id);
        if ($question == NULL)
            return false;

        $question->delete();
    }


    function model(): string
    {
        return "App\Models\Question";
    }


}
