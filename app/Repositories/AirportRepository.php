<?php


namespace App\Repositories;

use App\Models\Airport;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Eloquent\BaseRepository;


class AirportRepository extends BaseRepository
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



    public function store_airport($data_request)
    {
        return $this->model->create($data_request);

    }


    public function update_airport($data_request, $id)
    {
        $airport = $this->model->find($id);
        $airport->update($data_request);
        return $airport;

    }


    public function destroy_airport($id)
    {
        $airport = $this->model->find($id);
        if ($airport == NULL)
            return false;

        $airport->delete();
    }


    function model(): string
    {
        return "App\Models\Airport";
    }


}
