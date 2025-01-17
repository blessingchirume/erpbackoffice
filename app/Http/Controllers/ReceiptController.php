<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use App\Models\Product;
use App\Models\Provider;
use App\Models\Receipt;
use App\Models\ReceivedProduct;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceiptController extends Controller
{

    public function index()
    {
        $receipts = Receipt::paginate(25);

        return view('inventory.receipts.index', compact('receipts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $providers = Provider::all();

        $currencies = Currency::all();

        return view('inventory.receipts.create', compact('providers', 'currencies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Receipt $receipt)
    {
        $request->merge(['rate' => Currency::find($request->get('currency_id'))->rate, 'shop_id' => Auth::user()->shop->id]);
        $receipt = $receipt->create($request->all());

        return redirect()
            ->route('receipts.show', $receipt)
            ->withStatus('Receipt registered successfully, you can start adding the products belonging to it.');
    }

    /**
     * Display the specified resource.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $receipt = Receipt::find($id);
        return view('inventory.receipts.show', compact('receipt'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroy($receipt)
    {
        Receipt::find($receipt)->delete();

        return redirect()
            ->route('receipts.index')
            ->withStatus('Receipt successfully removed.');
    }

    /**
     * Finalize the Receipt for stop adding products.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function finalize($id)
    {
        $receipt = Receipt::find($id);
        $receipt->finalized_at = Carbon::now()->toDateTimeString();
        $receipt->save();

        foreach($receipt->products as $receivedproduct) {
            $receivedproduct->product->stock += $receivedproduct->stock;
            $receivedproduct->product->stock_defective += $receivedproduct->stock_defective;
            $receivedproduct->product->save();
        }

        return back()->withStatus('Receipt successfully completed.');
    }

    /**
     * Add product on Receipt.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function addproduct($id)
    {
        $receipt = Receipt::find($id);
        $products = Product::all();

        return view('inventory.receipts.addproduct', compact('receipt', 'products'));
    }

    /**
     * Add product on Receipt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function storeproduct(Request $request, $id)
    {

//        ReceivedProduct::create($request->all());

        $product = Product::find($request->get('product_id'));

        $receipt = Receipt::find($id);

        $receipt->total_purchases += ($product->unit_cost * $request->get('stock'));
        $receipt->save();

        return redirect()
            ->route('receipts.show', $receipt)
            ->withStatus('Product added successfully.');
    }

    /**
     * Editor product on Receipt.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function editproduct(Receipt $receipt, ReceivedProduct $receivedproduct)
    {
        $products = Product::all();

        return view('inventory.receipts.editproduct', compact('receipt', 'receivedproduct', 'products'));
    }

    /**
     * Update product on Receipt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function updateproduct(Request $request, Receipt $receipt, ReceivedProduct $receivedproduct)
    {
        $receivedproduct->update($request->all());

        return redirect()
            ->route('receipts.show', $receipt)
            ->withStatus('Product edited successfully.');
    }

    /**
     * Add product on Receipt.
     *
     * @param  Receipt  $receipt
     * @return \Illuminate\Http\Response
     */
    public function destroyproduct(Receipt $receipt, ReceivedProduct $receivedproduct)
    {
        $receivedproduct->delete();

        return redirect()
            ->route('receipts.show', $receipt)
            ->withStatus('Product removed successfully.');
    }
}
