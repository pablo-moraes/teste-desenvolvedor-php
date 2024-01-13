<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MultiDeleteController extends Controller
{
    protected Product|Customer|Order $model;

    public function __construct(Request $request)
    {
        $entity = $request->route('entity');

        $allowedEntities = ['product', 'order', 'customer'];

        if (!in_array($entity, $allowedEntities)) {
            abort(404);
        }

        $this->model = match ($entity) {
            'product' => new Product(),
            'order' => new Order(),
            'customer' => new Customer()
        };
    }

    public function destroy(Request $request, $entity): JsonResponse
    {
        try {
            $uuids = $request->uuids;

            $query = $this->model::whereIn('uuid', $uuids);

            if (!$query->exists()) {
                return response()->json([
                    'type' => 'error',
                    'errors' => [],
                    'message' => ucfirst($entity) .' not found',
                ], 404);
            }

            $query->delete();
            return response()->json([
                'type' => 'success',
                'body' => [],
                'message' => Str::plural($entity) . ' deleted successfully!'
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
