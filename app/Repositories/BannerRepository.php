<?php


namespace App\Repositories;

use App\Models\Banner;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Eloquent\BaseRepository;


class BannerRepository extends BaseRepository
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



    public function store_banner($data_request)
    {
        return $this->model->create($data_request);

    }


    public function update_banner($data_request, $id)
    {
        $banner = $this->model->find($id);
        $banner->update($data_request);
        return $banner;

    }


    public function destroy_banner($id)
    {
        $banner = $this->model->find($id);
        if ($banner == NULL)
            return false;

        $banner->delete();
    }


    function model(): string
    {
        return "App\Models\Banner";
    }


}
