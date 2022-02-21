<?php

namespace App\Http\Controllers;

use App\Filters\ProductFilter;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends ApiController {

    public function index(Request $request) {
        $query = ProductFilter::new ()->filters($request->all())->apply();
        $products = $query->paginate($this->limit());
        return $this->success(ProductResource::collection($products));
    }

    public function store(ProductRequest $request) {
        $product = Product::query()->create($request->validated());
        return $this->success($product);
    }

    public function show(Product $product) {
        return $this->success(ProductResource::make($product));
    }

    public function update(ProductRequest $request, Product $product) {
        $data = $request->validated();
        $product->update($data);
        return $this->success(ProductResource::make($product));
    }

    public function destroy(Product $product) {
        $product->delete();
        return $this->success(null, "Product Deleted");
    }
}
