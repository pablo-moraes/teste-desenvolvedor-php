<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\{
    DataTableAbstract,
    Facades\DataTables
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    private Order $order;

    public function __construct()
    {
        $this->order = new Order();
    }


    public function index(): JsonResponse|DataTableAbstract
    {
        try {
            $orders = $this->order::query()
                ->with([
                    'customer:uuid,name',
                    'product:uuid,name,price'
                ])->select('orders.*');

            return DataTables::eloquent($orders)
                ->addColumn('actions', function ($order) {
                    $btnEdit = '<a type="button" class="btn btn-primary" href="' . route('update_order_form', ['id' => $order->uuid]) . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                    $btnDelete = '<button type="button" class="btn btn-danger" value="' . $order->uuid . '" onclick="showDeleteConfirmation(this)"><i class="fa-solid fa-trash"></i> </button>';
                    return "<div class='text-right d-flex flex-wrap gap-2 justify-content-center'>$btnEdit $btnDelete</div>";
                })
                ->addColumn('total_price', function ($order) {
                    return $order->total_price;
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
            $order = $this->order::findByUuid($uuid)->with(['product:uuid,name as text', 'customer:uuid,name as text'])->first();
            if (!$order) {
                return response()->json([
                    'type' => 'error',
                    'errors' => [],
                    'message' => 'Order Not Found',
                ], 404);
            }

            $order->makeHidden(['created_at', 'updated_at', 'customer_id', 'product_id']);
            return response()->json([
                'type' => 'success',
                'body' => $order,
                'message' => 'Order loaded successfully!'
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
                'customer_id' => 'required|exists:customers,uuid',
                'product_id' => 'required|exists:products,uuid',
                'quantity' => 'required|integer'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'There was an error trying to create a product. Verify values and try again',
                    'errors' => $validator->errors()
                ], 422);
            }

            $order = $this->order::create($data);

            return response()->json([
                'type' => 'success',
                'body' => $order,
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
        $order = $this->order::findByUuid($uuid)->first();

        try {
            if (empty($order)) {
                return response()->json([
                    'type' => 'error',
                    'errors' => [],
                    'message' => 'Product Not Found',
                ], 404);
            }

            $data = $request->only(['quantity', 'customer_id', 'product_id']);
            $order->update($data);
            $order->makeHidden(['created_at', 'updated_at']);
            return response()->json([
                'type' => 'success',
                'body' => $order,
                'message' => 'Order updated successfully!'
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
            $order = $this->order::findByUuid($uuid);
            if (!$order) {
                return response()->json([
                    'type' => 'error',
                    'errors' => [],
                    'message' => 'Order Not Found',
                ], 404);
            }

            $order->delete();
            return response()->json([
                'type' => 'success',
                'body' => [],
                'message' => 'Order deleted successfully!'
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
