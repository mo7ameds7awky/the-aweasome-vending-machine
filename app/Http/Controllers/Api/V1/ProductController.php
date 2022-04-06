<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Resources\ProductsCollectionResource;
use App\Http\Resources\ProductsResource;
use App\Http\Resources\UsersResource;
use App\Models\Product;
use App\Services\ProductsService;
use Error;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    private ProductsService $service;

    /**
     * @param ProductsService $service
     */
    public function __construct(ProductsService $service)
    {
        $this->service = $service;
    }

    public function index(): JsonResponse
    {
        return response()->json(['data' => new ProductsCollectionResource(Product::paginate(5))], 200);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        try {
            $this->authorize('products_create');
        } catch (Exception|Error $e) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        DB::beginTransaction();
        try {
            if ($product = $this->service->createProduct($request->validated())) {
                DB::commit();
                return response()->json(['data' => ['product' => new ProductsResource($product)]], 201);
            }
            DB::rollBack();
            return response()->json([], 500);
        } catch (Exception|Error $e) {
            DB::rollBack();
            return response()->json([], 500);
        }
    }

    public function show(Product $product): JsonResponse
    {
        return response()->json(['data' => new ProductsResource($product)], 200);
    }

    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        try {
            $this->authorize('products_manage', $product);
        } catch (Exception|Error $e) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        DB::beginTransaction();
        try {
            if ($product = $this->service->updateProduct($product, $request->validated())) {
                DB::commit();
                return response()->json(['data' => new ProductsResource($product)], 200);
            }
            DB::rollBack();
            return response()->json([], 500);
        } catch (Exception|Error $e) {
            DB::rollBack();
            return response()->json([], 500);
        }
    }

    public function destroy(Product $product): JsonResponse
    {
        try {
            $this->authorize('products_manage', $product);
        } catch (Exception|Error $e) {
            return response()->json(['message' => 'Unauthorized.'], 403);
        }
        DB::beginTransaction();
        try {
            if ($product->delete()) {
                DB::commit();
                return response()->json(['data' => new ProductsResource($product)], 200);
            }
            DB::rollBack();
            return response()->json([], 500);
        } catch (Exception|Error $e) {
            DB::rollBack();
            return response()->json([], 500);
        }
    }
}
