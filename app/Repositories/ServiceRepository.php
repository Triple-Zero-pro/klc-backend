<?php


namespace App\Repositories;

use App\Models\Category;
use App\Models\ServiceAttribute;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Eloquent\BaseRepository;


class ServiceRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */


    public function index($category_id, $service_name = NULL, $lang = 'ar')
    {
        if ($category_id != 0)
            return $this->model->where('category_id', $category_id)->with(['category', 'serviceAttributes'])->paginate(15);

        if ($service_name)
            return $this->model->where('name_' . $lang . '', 'LIKE', '%' . $service_name . '%')->get();


        return $this->model->with(['category', 'serviceAttributes'])->paginate(15);
    }

    public function show($service_id)
    {
        return $this->model->find($service_id);
    }


    public function store_service($data_request)
    {
        $service  =  $this->model->create($data_request);
        $service_attributes =  ServiceAttribute::create([
            'service_id' => $service->id,
        ]);
        return $service;
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

    public function get_services_by_name($service_name, $lang)
    {
        return $this->model->where('name_' . $lang . '', 'LIKE', '%' . $service_name . '%')->get();
    }

    public function categories_statistics($time)
    {
        if ($time == 'today')
            $time = Carbon::today();
        elseif ($time == 'week')
            $time = Carbon::now()->subdays(7);
        elseif ($time == 'month')
            $time = Carbon::now()->subdays(30);
        else
            $time = Carbon::createFromFormat('Y-m-d', $time);
        return DB::table('orders')
            ->where('orders.created_at', '>=', $time)
            ->leftJoin('categories', 'orders.category_id', '=', 'categories.id')
            ->selectRaw('COUNT(orders.id) AS orders_numbers, SUM(orders.total) as orders_amounts')
            ->addSelect('categories.id')
            ->addSelect('categories.name_ar')
            ->groupBy('categories.id')
            ->groupBy('categories.name_ar')
            ->get();

    }

    public function services_by_categories_statistics($cat_id, $time)
    {
        if ($time == 'today')
            $time = Carbon::today();
        elseif ($time == 'week')
            $time = Carbon::now()->subdays(7);
        elseif ($time == 'month')
            $time = Carbon::now()->subdays(30);
        else
            $time = Carbon::createFromFormat('Y-m-d', $time);
        return DB::table('orders')
            ->where('orders.created_at', '>=', $time)
            ->leftJoin('services', 'orders.service_id', '=', 'services.id')
            ->leftJoin('categories', 'services.category_id', '=', 'categories.id')
            ->selectRaw('COUNT(orders.id) AS orders_numbers, SUM(orders.total) as orders_amounts')
            ->addSelect('services.id')
            ->addSelect('services.name_ar')
            ->where('services.category_id', $cat_id)
            ->groupBy('services.id')
            ->groupBy('services.name_ar')
            ->get();
    }


    function model(): string
    {
        return "App\Models\Service";
    }


}
