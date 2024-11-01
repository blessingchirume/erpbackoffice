<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SoldProduct;
use App\Models\Transaction;
use Carbon\Carbon;

use Illuminate\Http\Request;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // dd(1);
        $sales = Sale::latest()->paginate(25);

        return view('sales.index', compact('sales'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clients = Client::all();

        return view('sales.create', compact('clients'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Sale $model)
    {
        // dd($request);
        $existent = Sale::where('client_id', $request->get('client_id'))->where('finalized_at', null)->get();

        if($existent->count()) {
            return back()->withError('There is already an unfinished sale belonging to this customer. <a href="'.route('sales.show', $existent->first()).'">Click here to go to it</a>');
        }

        $sale = $model->create($request->all());

        return redirect()
            ->route('sales.show', ['sale' => $sale->id])
            ->withStatus('Sale registered successfully, you can start registering products and transactions.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // dd(1);
        $sale = Sale::find($id);
        return view('sales.show', ['sale' => $sale]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $sale = Sale::find($id);
        $sale->delete();

        return redirect()
            ->route('sales.index')
            ->withStatus('The sale record has been successfully deleted.');
    }

    public function finalize($id)
    {
        $sale = Sale::find($id);
        $sale->total_amount = $sale->products->sum('total_amount');

        foreach ($sale->products as $sold_product) {
            $product_name = $sold_product->product->name;
            $product_stock = $sold_product->product->stock;
            if($sold_product->qty > $product_stock) return back()->withError("The product '$product_name' does not have enough stock. Only has $product_stock units.");
        }

        foreach ($sale->products as $sold_product) {
            $sold_product->product->stock -= $sold_product->qty;
            $sold_product->product->save();
        }

        $sale->finalized_at = Carbon::now()->toDateTimeString();
        $sale->client->balance -= $sale->total_amount;
        $sale->save();
        $sale->client->save();

        return back()->withStatus('The sale has been successfully completed.');
    }

    public function addproduct($id)
    {
        $sale = Sale::find($id);
        $products = Product::all();

        return view('sales.addproduct', compact('sale', 'products'));
    }

    public function storeproduct(Request $request, $id, SoldProduct $soldProduct)
    {
        $sale = Sale::find($id);
        $request->merge(['item_cost' => 70]);

        $request->merge(['total_amount' => $request->get('price') * $request->get('qty')]);

        $soldProduct->create($request->all());

        // dd($request);

        return redirect()
            ->route('sales.show', ['sale' => $sale])
            ->withStatus('Product successfully registered.');
    }

    public function editproduct($id, SoldProduct $soldproduct)
    {
        $sale = Sale::find($id);

        $products = Product::all();

        return view('sales.editproduct', compact('sale', 'soldproduct', 'products'));
    }

    public function updateproduct(Request $request, Sale $sale, SoldProduct $soldproduct)
    {
        $request->merge(['total_amount' => $request->get('price') * $request->get('qty')]);

        $soldproduct->update($request->all());

        return redirect()->route('sales.show', $sale)->withStatus('Product successfully modified.');
    }

    public function destroyproduct(SoldProduct $soldproduct)
    {
        $soldproduct->delete();

        return back()->withStatus('The product has been disposed of successfully.');
    }

    public function addtransaction($id)
    {
        $sale = Sale::find($id);

        $payment_methods = PaymentMethod::all();

        return view('sales.addtransaction', compact('sale', 'payment_methods'));
    }

    public function storetransaction(Request $request, $id, Transaction $transaction)
    {
        $sale = Sale::find($id);
        switch($request->all()['type']) {
            case 'income':
                $request->merge(['title' => 'Payment Received from Sale ID: ' . $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Sale Return Payment ID: ' . $request->all('sale_id')]);

                if($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1) ]);
                }
                break;
        }


        $transaction->create($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus('Successfully registered transaction.');
    }

    public function edittransaction($id, Transaction $transaction)
    {
        $sale = Sale::find($id);

        $payment_methods = PaymentMethod::all();

        return view('sales.edittransaction', compact('sale', 'transaction', 'payment_methods'));
    }

    public function updatetransaction(Request $request, $id, Transaction $transaction)
    {
        $sale = Sale::find($id);

        switch($request->get('type')) {
            case 'income':
                $request->merge(['title' => 'Payment Received from Sale ID: '. $request->get('sale_id')]);
                break;

            case 'expense':
                $request->merge(['title' => 'Sale Return Payment ID: '. $request->get('sale_id')]);

                if($request->get('amount') > 0) {
                    $request->merge(['amount' => (float) $request->get('amount') * (-1)]);
                }
                break;
        }
        $transaction->update($request->all());

        return redirect()
            ->route('sales.show', compact('sale'))
            ->withStatus('Successfully modified transaction.');
    }

    public function destroytransaction(Sale $sale, Transaction $transaction)
    {
        $transaction->delete();

        return back()->withStatus('Transaction deleted successfully.');
    }
}
