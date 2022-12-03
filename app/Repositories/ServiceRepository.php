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


    public function index($category_id)
    {
        if ($category_id != 0)
            return $this->model->where('category_id',$category_id)->with(['category','serviceAttributes'])->paginate(15);

        return $this->model->with(['category','serviceAttributes'])->paginate(15);
    }

    public function show($service_id)
    {
        return $this->model->find($service_id);
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
        if ($service->image)
            Storage::disk('public')->delete($service->image);
    }

    public function get_services_by_category($category_id)
    {
        return $this->model->where('category_id', $category_id)
            ->get();
    }
    public function get_services_by_name($service_name,$lang)
    {
        return $this->model->where('name_'.$lang.'','LIKE','%'.$service_name.'%')->get();
    }


    function model(): string
    {
        return "App\Models\Service";
    }


}
