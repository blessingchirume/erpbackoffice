<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::paginate(25);

        return view('shops.index', compact('shops'));
    }

    public function create()
    {
        return view('shops.create');
    }

    public function store(Request $request, Shop $shop)
    {
        $shop->create($request->all());

        return redirect()
            ->route('shops.index')
            ->withStatus('Successfully Registered Shop.');
    }
    public function show($id)
    {
        $shop = Shop::find($id);
        return view('shops.show', compact('shop'));
    }

    public function update(Request $request, Shop $shop)
    {
        //
    }

    public function destroy(Shop $shop)
    {
        //
    }
}
