<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductCategoryRequest;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(ProductCategory $model)
    {
        $categories = ProductCategory::all();

        return response($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('inventory.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryRequest $request, ProductCategory $category)
    {
        $category->create($request->all());

        return redirect()
            ->route('categories.index')
            ->withStatus('Category successfully created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategory $category)
    {
        return view('inventory.categories.show', [
            'category' => $category,
            'products' => Product::where('product_category_id', $category->id)->paginate(25)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductCategory $category)
    {
        return view('inventory.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryRequest $request, ProductCategory $category)
    {
        $category->update($request->all());

        return redirect()
            ->route('categories.index')
            ->withStatus('Category successfully updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategory $category)
    {
        $category->delete();

        return redirect()
            ->route('categories.index')
            ->withStatus('Category successfully deleted.');
    }
}
