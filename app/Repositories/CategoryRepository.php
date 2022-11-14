<?php


namespace App\Repositories;

use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Eloquent\BaseRepository;


class CategoryRepository extends BaseRepository
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



    public function store_category($data_request)
    {
        return $this->model->create([
            'name' => [
                'en' => $data_request['name'],
                'ar' => $data_request['name_ar']
            ],
            'description' => [
                'en' => $data_request['description'],
                'ar' => $data_request['description_ar']
            ],
            'image' => $data_request['image'],
            'status' => $data_request['status'],
        ]);

    }


    public function update_category($data_request, $id)
    {
        $category = $this->model->find($id);
        $category->update([
            'name' => [
                'en' => $data_request['name'],
                'ar' => $data_request['name_ar']
            ],
            'description' => [
                'en' => $data_request['description'],
                'ar' => $data_request['description_ar']
            ],
            'image' => $data_request['image'],
            'status' => $data_request['status'],
        ]);
        return $category;

    }


    public function destroy_category($id)
    {
        $category = $this->model->find($id);
        if ($category == NULL)
            return false;

        $category->delete();
    }


    function model(): string
    {
        return "App\Models\Category";
    }


}
