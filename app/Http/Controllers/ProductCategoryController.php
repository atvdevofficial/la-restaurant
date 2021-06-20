<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductCategory\ProductCategoryDestroyRequest;
use App\Http\Requests\ProductCategory\ProductCategoryIndexRequest;
use App\Http\Requests\ProductCategory\ProductCategoryShowRequest;
use App\Http\Requests\ProductCategory\ProductCategoryStoreRequest;
use App\Http\Requests\ProductCategory\ProductCategoryUpdateRequest;
use App\Http\Resources\ProductCategoryResource;
use App\ProductCategory;
use Illuminate\Http\Request;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductCategoryIndexRequest $request)
    {
        $productCategories = ProductCategory::all();

        return ProductCategoryResource::collection($productCategories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductCategoryStoreRequest $request)
    {
        $productCategory = ProductCategory::create($request->validated());

        return new ProductCategoryResource($productCategory);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProductCategoryShowRequest $request, ProductCategory $productCategory)
    {
        return new ProductCategoryResource($productCategory);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function update(ProductCategoryUpdateRequest $request, ProductCategory $productCategory)
    {
        $productCategory->update($request->validated());

        return new ProductCategoryResource($productCategory);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProductCategory  $productCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductCategoryDestroyRequest $request, ProductCategory $productCategory)
    {
        $productCategory->delete();

        return response(null, 204);
    }
}
