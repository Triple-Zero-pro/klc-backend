<?php


namespace App\Repositories;

use App\Models\BannerType;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Eloquent\BaseRepository;


class BannerTypeRepository extends BaseRepository
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



    public function store_bannerType($data_request)
    {
        return $this->model->create($data_request);

    }


    public function update_bannerType($data_request, $id)
    {
        $bannerType = $this->model->find($id);
        $bannerType->update($data_request);
        return $bannerType;

    }


    public function destroy_bannerType($id)
    {
        $bannerType = $this->model->find($id);
        if ($bannerType == NULL)
            return false;

        $bannerType->delete();
    }


    function model(): string
    {
        return "App\Models\BannerType";
    }


}
