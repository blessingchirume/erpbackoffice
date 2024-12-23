<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Log;

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
        try {

//            $imageName = time().'.'.$request->file('image')->getClientOriginalExtension();
//            request()->image->move(public_path('images/uploads'), $imageName);
//            $request->merge(['image_url' => $imageName ]);
//            Log::info( $product->create($request->validated()));
            $model->create($request->except('image'));
            return response("Product created successfully", 200);
        } catch (\Throwable $th) {
//            return redirect()->back()->with('error', $th->getMessage());
            return response($th->getMessage(), 500);

        }
//        $product = Product::create($request->all());

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
