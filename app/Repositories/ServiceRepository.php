<?php


namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Eloquent\BaseRepository;


class ServiceRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */


    public function index()
    {
        return $this->model->with(['category' => function ($query) {
                $query->select('id', 'name');
            }])->paginate(15);
    }



    public function store_service($data_request)
    {
        return $this->model->create($data_request);

    }


    public function update_service($data_request, $id)
    {
        $service = $this->model->find($id);
        $service->update($data_request);
        return $service;

    }


    public function destroy_service($id)
    {
        $service = $this->model->find($id);
        if ($service == NULL)
            return false;

        $service->delete();
    }
    public function get_services_by_category($category_id)
    {
        return $this->model->where('category_id',$category_id)
            ->select('services.image','services.price','services.name',)
            ->get();
    }


    function model(): string
    {
        return "App\Models\Service";
    }


}
