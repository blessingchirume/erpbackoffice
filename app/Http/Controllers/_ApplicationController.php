<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ApplicationController extends Controller
{
    public function order(Request $request)
    {
        $data = $request->validate([]);

        $order = new Order();

        // return response($request);

        $order->create([
            'order_number' => $request->orderDetails["order_number"],
            'order_ref_number' => $request->orderDetails["order_ref_number"],
            'payment_status' => $request->orderDetails["payment_status"],
            'customer_delivery_status' => $request->orderDetails["customer_delivery_status"],
            'admin_delivery_status' => $request->orderDetails["admin_delivery_status"],
            'delivery_date' => $request->orderDetails["delivery_date"],
            'approval_status' => $request->orderDetails["approval_status"],
            'user_id' => Auth::user()->id

        ]);


        foreach ($request->orderDetails["order_items"] as $row) {
            $order->items()->attach(Item::where('id', $row['item_id'])->first());
        }
    }

    public function orders()
    {
        return response(Auth::user()->orders->load('items')->map(function ($order) {
            return [
                "id" => $order->id,
                "order_number" => $order->order_number,
                "order_ref_number" => $order->order_ref_number,
                "payment_status" => $order->payment_status,
                "payment_date"=> $order->payment_date,
                "customer_delivery_status" => $order->customer_delivery_status,
                "expected_delivery_date" => $order->expected_delivery_date,
                "delivery_date" => $order->delivery_date,
                "admin_delivery_status" => $order->admin_delivery_status,
                "dispatch_date" => $order->dispatch_date,
                "approval_status" => $order->approval_status,
                "shipping_address" => $order->shipping_address,
                "user_id" => $order->user_id,
                "total" => $order->total,
                "items" => $order->items->map(function ($item) {
                    return [
                        "id" => $item->id,
                        "item_code" => $item->item_code,
                        "item_description" => $item->item_description,
                        "category" => $item->category,
                        "image" => $item->image,
                        "price" => $item->price,
                    ];
                })
            ];
        }));
    }

    public function items()
    {
        $items = Item::all();
        return response()->json(['success' => $items, 'error' => null]);
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required',
            'phone' => 'required'
        ]);
        try {
            $user = new User();
            $user->create([
                'name' => $request->name,
                'surname' => $request->surname,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make('12345678'),
            ]);
            return response(['success' => 'user created successfully', 'error' => null]);
        } catch (\Throwable $th) {
            return  response(['success' => null, 'error' => $th->getMessage()]);
        }
    }

    public function confirmDelivery(Request $request)
    {
        $id = $request->validate([
            'id' => 'required',
        ]);

        $order = Order::find($id)->first();


        if ($order->payment_status == 0 || $order->admin_delivery_status == 0) {
            return response("Failure: Some operations have not yet been mate, please contact support");
        }

        if ($order->customer_delivery_status == 1) {
            return response("Failure: Delivery already confirmed");
        }

        try {
            $order->update([
                'customer_delivery_status' => 1,
                "delivery_date" => date('Y-m-d')
            ]);

            return response('Delivery confirmed', 201);

        } catch (\Throwable $th) {
            return response($th->getMessage(), 500);
        }
    }
}
