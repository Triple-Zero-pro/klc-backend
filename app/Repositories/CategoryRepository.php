<?php


namespace App\Repositories;

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



    public function store_category($data_request)
    {
        return $this->model->create($data_request);

    }

    public function edit_category($id)
    {
        $data = [];
        $data['category'] = $this->model->findOrFail($id);
        $data['parents'] = $this->model->where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orWhere('parent_id', '<>', $id);
            })
            ->get();

        return $data;

    }

    public function update_category($data_request, $id)
    {
        $category = $this->model->find($id);
        return $category->update($data_request);

    }


    public function destroy_category($id)
    {
        $category = $this->model->find($id);
        if ($category == NULL)
            return false;

        $category->delete();
        /*if ($category->image)
            Storage::disk('public')->delete($category->image);*/
    }


    function model(): string
    {
        return "App\Models\Category";
    }


}
