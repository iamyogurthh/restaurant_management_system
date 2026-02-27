<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Models\Order;
use App\Models\Table;
use Illuminate\Http\Request;

class OrderController extends Controller
{

    public function index()
    {
        $dishes = Dish::orderBy('id')->get();
        $tables =   Table::all();

        $status = array_flip(config('res.order_status'));
        $orders = Order::where('status', 4)->get();

        return view('order_form', compact('dishes', 'tables', 'orders', 'status'));
    }

    public function submit(Request $request)
    {
        $data = array_filter($request->except('_token', 'table'));

        if (!$data) {
            return redirect('/')->with('error_message', 'Invalid Order!');
        }

        $order_id = rand();


        foreach ($data as $key => $value) {
            if ($value > 1) {
                for ($i = 1; $i <= $value; $i++) {
                    $this->saveOrder($key, $request, $order_id);
                }
            } else {
                $this->saveOrder($key, $request, $order_id);
            }
        }

        return redirect('/')->with('message', 'Order submitted successfully.');
    }

    public function saveOrder($dish_id, $request, $order_id)
    {
        $order = new Order();
        $order->order_id = $order_id;
        $order->dish_id = $dish_id;
        $order->table_id = (int)$request->table;
        $order->status = config('res.order_status.new');
        $order->save();
    }

    public function serve(Order $order)
    {
        $order->status = config('res.order_status.done');
        $order->save();
        return redirect(to: '/')->with('message', value: 'Order Served');
    }
}
