<?php


namespace App\Repositories;

use App\Models\Order;
use Prettus\Repository\Eloquent\BaseRepository;


class ClientRepository extends BaseRepository
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

    public function update_client($data_request, $id)
    {
        $client = $this->model->find($id);
        $client->update($data_request);
        return $client;

    }

    public function destroy_client($id)
    {
        $client = $this->model->find($id);
        if ($client == NULL)
            return false;

        $client->delete();
    }

    public function client_orders($client_id)
    {
        return Order::where('user_id', $client_id)->get();
    }


    function model(): string
    {
        return "App\Models\User";
    }


}
