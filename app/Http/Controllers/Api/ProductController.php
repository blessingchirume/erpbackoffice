<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all()->map(function ($product) {
            return [
                "id" => $product->id,
                "serial_number" => $product->serial_number,
                "name" => $product->name,
                "description" => $product->description,
                "product_category_id" => $product->product_category_id,
                "unit_cost" => $product->unit_cost,
                "price" => $product->price,
                "stock" => $product->stock,
                "stock_defective" => $product->stock_defective,
                "price_list" => $product->priceList->map(function ($price){
                    return [
                        "name" => $price->name,
                        "base_price" => $price->base_price,
                        "base_quantity" => $price->base_quantity
                    ];
                })
            ];
        });

        return response($products);
    }

    public function store(ProductRequest $request, Product $model)
    {
        $data = $request->validate([
            'serial_number'=> 'required',
            'name'=> 'required',
            'description'=> 'required',
            'product_category_id'=> 'required',
            'unit_cost'=> 'required',
            'price'=> 'required',
            'stock'=> 'required',
            'stock_defective'=> 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:20480'
        ]);

//        return $request;

        try {

            $imageName = time().'.'.$request->file('image')->getClientOriginalExtension();
            request()->image->move(public_path('images/uploads'), $imageName);

            $user = new Item();
            $user->create($request->except('image'));
            return redirect()->route('item.index')->with('success', 'product item created successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', $th->getMessage());
        }
        $product = Product::create($request->all());

        return response("Product created successfully", 200);
    }

    public function show(Product $product)
    {
        $solds = $product->solds()->latest()->limit(25)->get();

        $receiveds = $product->receiveds()->latest()->limit(25)->get();

        return view('inventory.products.show', compact('product', 'solds', 'receiveds'));
    }

    public function edit(Product $product)
    {
        $categories = ProductCategory::all();

        return view('inventory.products.edit', compact('product', 'categories'));
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->except('id'));
        return response("Product updated successfully.", 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()
            ->route('products.index')
            ->withStatus('Product removed successfully.');
    }
}
