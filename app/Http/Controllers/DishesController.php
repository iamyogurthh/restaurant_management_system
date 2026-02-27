<?php

namespace App\Http\Controllers;

use App\Http\Requests\DishCreateRequest;
use App\Models\Category;
use App\Models\Dish;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


class DishesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dishes = Dish::all();

        return view('kitchen.dish', compact('dishes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('kitchen.dish_create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DishCreateRequest $request)
    {
        //$dish = new Dish();
        //$dish->name = $request->name;
        //$dish->category_id = $request->category;
        //$dishImagePathName  = date('YmdHis') . "." . $request->dish_image->getClientOriginalExtension();
        //$request->dish_image->move(public_path('images'), $dishImagePathName);
        //$dish->image = $dishImagePathName;

        //upload image
        $dishImagePathName  = date('YmdHis') . "." . $request->dish_image->getClientOriginalExtension();
        //save image in public/images folder
        $request->dish_image->move(public_path('images'), $dishImagePathName);

        //more shorter way
        $validatedData = $request->validated();
        Dish::create($validatedData + ['image' => $dishImagePathName, 'category_id' => $request->category]);

        return redirect('/dish')->with('message', 'Dish was created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dish $dish)
    {
        $categories = Category::all();
        return view('kitchen.dish_edit', compact('dish', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dish $dish)
    {
        request()->validate([
            'name' => 'required',
            'category' => 'required',
        ]);

        $oldImagePath = public_path('images/' . $dish->image);

        $dish->name = $request->name;
        $dish->category_id = $request->category;
        if ($request->dish_image) {
            //upload image
            $dishImagePathName  = date('YmdHis') . "." . $request->dish_image->getClientOriginalExtension();
            //save image in public/images folder
            $request->dish_image->move(public_path('images'), $dishImagePathName);
            $dish->image = $dishImagePathName;

            //delete the old image
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }

        $dish->save();
        return redirect('/dish')->with('message', 'Dish updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dish $dish)
    {

        $oldImagePath = public_path('images/' . $dish->image);
        if (File::exists($oldImagePath)) {
            File::delete($oldImagePath);
        }
        $dish->delete();
        return redirect('/dish')->with('message', 'Dish deleted successfully.');
    }

    public function order()
    {
        $status = array_flip(config('res.order_status'));
        $orders = Order::whereIn('status', [1, 2])->get();

        return view('kitchen.order', compact('orders', 'status'));
    }

    public function approve(Order $order)
    {
        $order->status = config('res.order_status.processing');
        $order->save();
        return redirect('/order')->with('message', 'Order Approved');
    }

    public function cancel(Order $order)
    {
        $order->status = config('res.order_status.cancel');
        $order->save();
        return redirect('/order')->with('message', 'Order Canceled');
    }

    public function ready(Order $order)
    {
        $order->status = config('res.order_status.ready');
        $order->save();
        return redirect('/order')->with('message', 'Order ready');
    }
}
