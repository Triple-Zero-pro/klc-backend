<?php


namespace App\Repositories;

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
        return $this->model->with(['service' => function ($query) {
            $query->select('id', 'title');
        }])->where('service_id',$service_id)->paginate(15);
    }


    public function store_serviceAttribute($data_request)
    {
        return $this->model->create($data_request);

    }

    public function show($service_attributes_id)
    {
        return $this->model->find($service_attributes_id);
    }

    public function destroy_serviceAttribute($service_attributes_id)
    {
        $serviceAttribute = $this->model->find($service_attributes_id);
        if ($serviceAttribute == NULL)
            return false;

        $serviceAttribute->delete();
    }


    function model(): string
    {
        return "App\Models\ServiceAttribute";
    }



}
