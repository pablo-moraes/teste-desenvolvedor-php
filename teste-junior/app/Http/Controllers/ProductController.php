<?php

namespace App\Http\Controllers;

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


    public function index(): JsonResponse|DataTableAbstract
    {
        try {
            $products = $this->product::all();
            return DataTables::of($products)
                ->addColumn('actions', function ($product) {
                    $btnEdit = '<a type="button" class="btn btn-primary" href="' . route('update_product_form', ['id' => $product->uuid]) . '">Editar</a>';
                    $btnDelete = '<button type="button" class="btn btn-danger" value="'.$product->uuid.'" onclick="showDeleteConfirmation(this)">Excluir</button>';
                    return "<div class='text-right'>$btnEdit $btnDelete</div>";
                })
                ->rawColumns(['actions'])
                ->make();
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
            $product = $this->product::find($uuid);
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



    public function store(Request $request)
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
        $product = $this->product::find($uuid)->first();

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
            $product = $this->product::find($uuid);
            if (!$product) {
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
}
