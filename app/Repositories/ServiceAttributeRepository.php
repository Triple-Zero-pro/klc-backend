<?php


namespace App\Repositories;

use App\Models\ServiceAttribute;
use Prettus\Repository\Eloquent\BaseRepository;


class ServiceAttributeRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */


    public function index($service_id)
    {
        return $this->model->where('service_id',$service_id)->get();
    }


    public function store_serviceAttribute($data_request)
    {
        $service_attributes =  $this->model->where('service_id',$data_request['service_id'])->first();
        if ($service_attributes)
             return $service_attributes->update($data_request);

        return ServiceAttribute::create($data_request);


    }



    function model(): string
    {
        return "App\Models\ServiceAttribute";
    }



}
