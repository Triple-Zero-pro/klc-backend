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
        return ServiceAttribute::where('service_id',$data_request['service_id'])->UpdateOrCreate([
                'from' => $data_request['from'],
                'to' => $data_request['to'],
                'appointment_date' => $data_request['appointment_date'],
                'appointment_time' => $data_request['appointment_time'],
                'images' => $data_request['images'],
                'gender' => $data_request['gender'],
                'embassy' => $data_request['embassy'],
                'select_service' => $data_request['select_service'],
                'employee_status' => $data_request['employee_status'],
            ]);

    }



    function model(): string
    {
        return "App\Models\ServiceAttribute";
    }



}
