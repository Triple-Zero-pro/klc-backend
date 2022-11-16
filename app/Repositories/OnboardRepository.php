<?php


namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Eloquent\BaseRepository;


class OnboardRepository extends BaseRepository
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



    public function store_onboard($data_request)
    {
        return $this->model->create($data_request);

    }


    public function update_onboard($data_request, $id)
    {
        $onboard = $this->model->find($id);
        $onboard->update($data_request);
        return $onboard;

    }


    public function destroy_onboard($id)
    {
        $onboard = $this->model->find($id);
        if ($onboard == NULL)
            return false;

        $onboard->delete();
    }


    function model(): string
    {
        return "App\Models\Onboard";
    }


}
