<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\ProductDestroyRequest;
use App\Http\Requests\Product\ProductIndexRequest;
use App\Http\Requests\Product\ProductShowRequest;
use App\Http\Requests\Product\ProductStoreRequest;
use App\Http\Requests\Product\ProductUpdateRequest;
use App\Http\Resources\ProductResource;
use App\Product;
use App\ProductCategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductIndexRequest $request)
    {
        $category = $request->input('category') ?? null;

        if ($category) {
            $products = Product::select('products.*')->join('product_product_category', 'product_product_category.product_id', 'products.id')->where('product_product_category.product_category_id', $category)->with('productCategories')->get();
        } else {
            $products = Product::with('productCategories')->get();
        }

        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
    {
        $product = Product::create($request->validated());
        $product->productCategories()->sync($request->validated()['product_categories']);
        $product->load('productCategories');

        return new ProductResource($product);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(ProductShowRequest $request, Product $product)
    {
        $product->load('productCategories');
        return new ProductResource($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
    {
        $product->update($request->validated());
        $product->productCategories()->sync($request->validated()['product_categories']);
        $product->load('productCategories');

        return new ProductResource($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductDestroyRequest $request, Product $product)
    {
        $product->delete();

        return response(null, 204);
    }
}
