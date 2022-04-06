<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductsService
{
    public function createProduct($validatedData)
    {
        return Product::create([
            'productName' => $validatedData['productName'],
            'amountAvailable' => $validatedData['amountAvailable'],
            'cost' => $validatedData['cost'],
            'sellerId' => Auth::user()->id,
        ]);
    }

    public function updateProduct(Product $product, $validatedData): Product
    {
        if (isset($validatedData['productName'])){
            $product->productName = $validatedData['productName'];
        }

        if (isset($validatedData['amountAvailable'])){
            $product->password = $validatedData['amountAvailable'];
        }

        if (isset($validatedData['cost'])){
            $product->cost = $validatedData['cost'];
        }

        $product->save();

        return $product;
    }
}
