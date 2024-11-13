<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    public function index(){
        $categories = ProductCategory::all();
        return response($categories, 200);
    }

    public function store(ProductCategoryRequest $request)
    {
        $product = ProductCategory::create($request->all());
        return response("Category created successfully", 200);
    }
}
