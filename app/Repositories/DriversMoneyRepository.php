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
        return $this->model->with('driver')->get();
    }


    public function show($id)
    {
        return $this->model->with('driver')->find($id);
    }



    public function store_DriversMoney($data_request)
    {
        return $this->model->create($data_request);

    }

    public function statistics()
    {
        $data= [];
         $data['total_money'] = $this->model->sum('amount');
         $data['total_money_salary'] = $this->model->where('type','salary')->sum('amount');
         $data['total_money_petrol'] = $this->model->where('type','petrol')->sum('amount');
         $data['total_monies_count'] = $this->model->count('id');
         return $data;

    }


    function model(): string
    {
        return "App\Models\DriversMoney";
    }


}
