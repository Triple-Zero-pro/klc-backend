<?php


namespace App\Repositories;


use App\Models\Payment;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;


class OrderRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */


    public function index()
    {
        return $this->model->with(['user','service','airport'])->paginate(15);
    }

    public function show($order_id)
    {
        return $this->model->where('id',$order_id)->with(['user','service','airport'])->first();
    }


    public function store_order($data_request)
    {
        $order =  $this->model->create($data_request);
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->amount = $order->total;
        $payment->currency = 'KWD';
        $payment->method = 'KNET';
        $payment->status = 'completed';
        $payment->transaction_id = '';
        $payment->save();
        return $order;

    }


    public function update_order($data_request, $id)
    {
        $order = $this->model->find($id);
        $order->update($data_request);
        return $order;

    }

    public function assign_order($data_request, $id)
    {
        $order = $this->model->find($id);
        $order->update([
            'driver_id'=>$data_request['driver_id']
        ]);
        return $order;

    }
    public function update_status($data_request, $order_id)
    {
        $order = $this->model->find($order_id);
        $order->update([
            'status' => $data_request->status
        ]);
        return $order;

    }


    public function destroy_order($id)
    {
        $order = $this->model->find($id);
        if ($order == NULL)
            return false;

        $order->delete();
    }

    public function get_orders_by_user_id()
    {
        return $this->model->where('user_id', Auth::user()->id)->with(['service','airport'])->get();
    }


    function model(): string
    {
        return "App\Models\Order";
    }


}
