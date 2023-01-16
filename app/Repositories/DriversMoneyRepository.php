<?php


namespace App\Repositories;

use App\Models\Airport;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Eloquent\BaseRepository;


class DriversMoneyRepository extends BaseRepository
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



    public function store_DriversMoney($data_request)
    {
        return $this->model->create($data_request);

    }


    function model(): string
    {
        return "App\Models\DriversMoney";
    }


}
