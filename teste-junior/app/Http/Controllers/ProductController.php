<?php

namespace App\Http\Controllers;

use App\DataTables\ProductsDataTable;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\{
    DataTableAbstract,
    Facades\DataTables
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    private Product $product;
    public function __construct() {
        $this->product = new Product();
    }


    public function index(ProductsDataTable $productsDataTable): JsonResponse|DataTableAbstract
    {
        try {
            return $productsDataTable->dataTable();
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'There was an error trying to process the request',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }

    public function show(string $uuid): JsonResponse
    {
        try {
            $product = $this->product::findByUuid($uuid)->first();
            if (!$product) {
                return response()->json([
                    'type' => 'error',
                    'errors' => [],
                    'message' => 'Product Not Found',
                ], 404);
            }

            $product->makeHidden(['created_at', 'updated_at']);
            return response()->json([
                'type' => 'success',
                'body' => $product,
                'message' => 'Product loaded successfully!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'There was an error trying to process the request',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }



    public function store(Request $request): JsonResponse
    {
        try {
            $data = $request->all();
            $validator = Validator::make($data, [
                'name' => 'required|string|min:3|unique:products,name',
                'bar_code' => 'required|string',
                'price' => 'required'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'There was an error trying to create a product. Verify values and try again',
                    'errors' => $validator->errors()
                ], 422);
            }

            $product = $this->product::create($data);

            return response()->json([
                'type' => 'success',
                'body' => $product,
                'message' => 'Product created successfully!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'There was an error trying to process the request',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }

    public function update(Request $request, string $uuid): JsonResponse
    {
        $product = $this->product::findByUuid($uuid)->first();

        try {
            if (empty($product)) {
                return response()->json([
                    'type' => 'error',
                    'errors' => [],
                    'message' => 'Product Not Found',
                ], 404);
            }

            $data = $request->only(['name', 'bar_code', 'price']);
            $product->update($data);
            $product->makeHidden(['created_at', 'updated_at']);
            return response()->json([
                'type' => 'success',
                'body' => $product,
                'message' => 'Product updated successfully!'
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'There was an error trying to process the request',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }

    public function destroy(string $uuid): JsonResponse
    {
        try {
            $product = $this->product::findByUuid($uuid);

            if (!$product->exists()) {
                return response()->json([
                    'type' => 'error',
                    'errors' => [],
                    'message' => 'Product Not Found',
                ], 404);
            }

            $product->delete();
            return response()->json([
                'type' => 'success',
                'body' => [],
                'message' => 'Product deleted successfully!'
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'type' => 'error',
                'message' => 'There was an error trying to process the request',
                'errors' => [$th->getMessage()]
            ], 500);
        }
    }

    public function search(Request $request): JsonResponse
    {
        $search = $request->search;
        $page = $request->page;


        $products = $this->product::query()
            ->select('uuid as id', 'name as text')
            ->where('name', 'like', "%$search%")
            ->paginate(20, ['*'], 'page', $page);
        return response()->json([
            'type' => 'success',
            'body' => $products,
            'message' => 'Products loaded successfully!'
        ]);
    }
}
