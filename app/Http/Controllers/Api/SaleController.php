<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SoldProduct;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Cast\Double;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::whereDate('created_at', '=', date('Y/m/d'))->where('shop_id', Auth::user()->shop->id ?? 1)->get()->map(function ($sale) {
            return [
                "employee" => $sale->user->name,
                "client" => $sale->client->name,
                "discount" => $sale->discount,
                "tendered_amount" => $sale->tendered_amount,
                "date" =>  Carbon::createFromFormat('Y-m-d H:i:s', $sale->created_at),
                "total_amount" => $sale->total_amount,
                "sold_products" => $sale->products->map(function ($product) {
                    return [
                        "name" => $product->product->name,
                        "qty" => $product->qty,
                        "price" => $product->price,
                        "total_amount" => $product->total_amount,
                    ];
                })
            ];
        });

        return response($sales);
    }

    public function store(Request $request)
    {
        $existent = Sale::where('client_id', $request->get('client_id'))->where('finalized_at', null)->get();

        if ($existent->count()) {

            return response('There is already an unfinished sale belonging to this customer.', 400);
        }

        $request->merge(['shop_id' => Auth::user()->shop->id]);

        try {
            $sale = Sale::create($request->all());
            foreach ($request->products as $value) {
                $this->storeproduct($value, $sale);
            }
            $sale->total_amount = $sale->products->sum('total_amount');
            foreach ($sale->products as $sold_product) {
                $product_name = $sold_product->product->name;
                $product_stock = $sold_product->product->stock;
                if ($sold_product->qty > $product_stock) return response("The product '$product_name' does not have enough stock. Only has $product_stock units.", 500);
            }
            foreach ($sale->products as $sold_product) {
                $sold_product->product->stock -= $sold_product->qty;
                $sold_product->product->save();
            }

            $sale->finalized_at = Carbon::now()->toDateTimeString();
            $sale->client->balance -= $sale->total_amount;
            $sale->save();
            $sale->client->save();
            switch ($request->all()['type']) {
                case 'income':
                    $request->merge(['title' => 'Payment Received from Sale ID: ' . $request->get('sale_id')]);
                    break;

                case 'expense':
                    $request->merge(['title' => 'Sale Return Payment ID: ' . $request->all('sale_id')]);

                    if ($request->get('amount') > 0) {
                        $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                    }
                    break;
            }
            Transaction::create([
                'currency_id' => 1,
                'client_id' => $request->client_id,
                'user_id' => Auth::user()->id,
                'type' => $request->all()['type'],
                'payment_method_id' => "1",
                'amount' => $sale->total_amount,
                'reference' => 'ref',
                'title' => 'Payment Received from Customer ID: ' . $request->client_id,
                'shop_id' => $sale->shop_id
            ]);
            $client = Client::find($request->get('client_id'));
            $client->balance += $request->get('total_amount');
            $client->save();

            $response = [
                "id" => (int)(date('Ymd'). $sale->id),
                "employee" => $sale->user->name,
                "client" => $sale->client->name,
                "discount" => (Double)$sale->discount,
                "tendered_amount" => (Double)$sale->tendered_amount,
                "change" => (Double)$sale->change,
                "date" =>  Carbon::createFromFormat('Y-m-d H:i:s', $sale->created_at),
                "total_amount" => (Double)$sale->total_amount,
                "sold_products" => $sale->products->map(function ($product) {
                    return [
                        "name" => $product->product->name,
                        "qty" => $product->qty,
                        "price" => (Double)$product->price,
                        "total_amount" => (Double)$product->total_amount,
                    ];
                })
            ];

            return response($response, 201);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 500);
        }
    }

    public function storeproduct($value, Sale $sale)
    {
        $data = [
            "applied_vat" => $value["applied_vat"],
            "item_cost"=> $value["item_cost"],
            "sale_id" => $sale->id,
            "product_id" => $value["product_id"],
            "price" => $value["price"],
            "qty" => $value["qty"],
            "total_amount" =>  $value["price"] * $value["qty"]
        ];
        SoldProduct::create($data);
    }

    public function storetransaction(Request $request, Sale $sale)
    {
        return response("Now adding transaction");

        switch ($request->all()['type']) {
            case 'income':
                $request->merge(['title' => 'Payment Received from Sale ID: ' . $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Sale Return Payment ID: ' . $request->all('sale_id')]);

                if ($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                }
                break;
        }



        Transaction::create([
            'client_id' => $request->client_id,
            'user_id' => Auth::user()->id,
            'type' => $request->all()['type'],
            'payment_method_id' => "1",
            'amount' => $sale->total_amount,
            'reference' => 'ref',
            'title' => 'Payment Received from Customer ID: ' . $request->client_id
        ]);

        $client = Client::find($request->get('client_id'));
        $client->balance += $request->get('total_amount');
        $client->save();

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus('Successfully registered transaction.');
    }

    public function updatetransaction(Request $request, Sale $sale, Transaction $transaction)
    {
        switch ($request->get('type')) {
            case 'income':
                $request->merge(['title' => 'Payment Received from Sale ID: ' . $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Sale Return Payment ID: ' . $request->get('sale_id')]);

                if ($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                }
                break;
        }
        $transaction->update($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus('Successfully modified transaction.');
    }
}
