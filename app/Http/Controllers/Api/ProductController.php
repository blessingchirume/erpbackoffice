<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all()->map(function ($product) {
            return [
                "id" => $product->id,
                "serial_number" => $product->serial_number,
                "image_url" => $product->image_url,
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
            $model->create($request->validated());
            return response("Product created successfully", 200);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 500);

        }

        return response("Product created successfully", 200);
    }

    public function storeWithImage(ProductRequest $request, Product $model)
    {
        try {
//            $validator = Validator::make($request->all(), [
//                'name'=> 'required',
//                'description'=> 'required',
//                'product_category_id'=> 'required',
//                'unit_cost'=> 'required',
//                'price'=> 'required',
//                'stock'=> 'required',
//                'stock_defective'=> 'required',
//                'image' => 'required'
//            ]);
//
//            if ($validator->fails()) {
//                return response()->json(['errors' => $validator->errors()], 422);
//            }

            $imageName = time().'.'.$request->file('image')->getClientOriginalExtension();
            request()->image->move(public_path('images/uploads'), $imageName);
            $request->merge(['image_url' => url('images/uploads/'.$imageName) ]);

            $model->create($request->except('image'));
            return response("Product created successfully", 200);
        } catch (\Throwable $th) {
            return response($th->getMessage(), 500);

        }
    }

    public function update(ProductRequest $request, $id)
    {
        $product = Product::find($id);
        $product->update($request->except('id'));
        return response("Product updated successfully.", 200);
    }

}
