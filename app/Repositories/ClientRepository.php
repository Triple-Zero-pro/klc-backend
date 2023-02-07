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


    public function index($request)
    {
        $clients =  $this->model->where('status','<>',NULL);
        if ($request['name']) {
            $clients->where('name', 'LIKE','%'. $request['name'].'%');
        }
        if ($request['email']) {
            $clients->where('email', 'LIKE','%'. $request['email'].'%');
        }
        if ($request['status']) {
            $clients->where('status', 'LIKE','%'. $request['status'].'%');
        }
        return $clients->paginate(10);

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
        return Order::where('user_id', $client_id)->paginate();
    }
    public function client_banned($client_id)
    {
        $client = $this->model->find($client_id);
        $client->status = 'banned';
        $client->save();
        return $client;

    }
    public function client_active($client_id)
    {
        $client = $this->model->find($client_id);
        $client->status = 'active';
        $client->save();
        return $client;

    }

    function model(): string
    {
        return "App\Models\User";
    }


}
