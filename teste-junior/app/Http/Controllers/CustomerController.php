<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTableAbstract;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{
    private Customer $customer;

    public function __construct()
    {
        $this->customer = new Customer();
    }

    public function index(): JsonResponse|DataTableAbstract
    {
        try {
            $customers = $this->customer::query();
            return DataTables::eloquent($customers)
                ->addColumn('actions', function ($customer) {
                    $btnEdit = '<a type="button" class="btn btn-primary" href="' . route('update_customer_form', ['id' => $customer->uuid]) . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                    $btnDelete = '<button type="button" class="btn btn-danger" value="' . $customer->uuid . '" onclick="showDeleteConfirmation(this)"><i class="fa-solid fa-trash"></i></button>';
                    return "<div class='text-right d-flex flex-wrap gap-2 justify-content-center'>$btnEdit $btnDelete</div>";
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
            $customer = $this->customer::findByUuid($uuid)->first();
            if (!$customer) {
                return response()->json([
                    'type' => 'error',
                    'errors' => [],
                    'message' => 'Customer Not Found',
                ], 404);
            }

            $customer->makeHidden(['created_at', 'updated_at']);
            return response()->json([
                'type' => 'success',
                'body' => $customer,
                'message' => 'Customer loaded successfully!'
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
                'name' => 'required|string|min:3',
                'email' => 'required|email|unique:customers,email',
                'document' => 'required|cpf|unique:customers,document'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'There was an error trying to create a customer. Verify values and try again',
                    'errors' => $validator->errors()
                ], 422);
            }

            $customer = $this->customer::create($data);

            return response()->json([
                'type' => 'success',
                'body' => $customer,
                'message' => 'Customer created successfully!'
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
        $customer = $this->customer::findByUuid($uuid)->first();

        try {

            $data = $request->only(['name', 'email', 'document']);
            $validator = Validator::make($data, [
                'name' => 'required|string|min:3',
                'email' => [
                    'required',
                    'email',
                    Rule::unique('customers')->ignore($uuid, 'uuid')
                ],
                'document' => [
                    'required',
                    'cpf',
                    Rule::unique('customers')->ignore($uuid, 'uuid')
                ]
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'type' => 'error',
                    'message' => 'There was an error trying to create a customer. Verify values and try again',
                    'errors' => $validator->errors()
                ], 422);
            }

            if (empty($customer)) {
                return response()->json([
                    'type' => 'error',
                    'errors' => [],
                    'message' => 'Customer Not Found',
                ], 404);
            }

            $customer->update($data);
            $customer->makeHidden(['created_at', 'updated_at']);
            return response()->json([
                'type' => 'success',
                'body' => $customer,
                'message' => 'Customer updated successfully!'
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
            $customer = $this->customer::findByUuid($uuid);
            if (!$customer) {
                return response()->json([
                    'type' => 'error',
                    'errors' => [],
                    'message' => 'Customer Not Found',
                ], 404);
            }

            $customer->delete();
            return response()->json([
                'type' => 'success',
                'body' => [],
                'message' => 'Customer deleted successfully!'
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
        $query = $this->customer::query()
            ->select('uuid as id', 'name as text')
            ->where('name', 'like', "%$search%");

        $customers = $query->paginate(20, ['*'], 'page', $page);

        return response()->json([
            'type' => 'success',
            'body' => $customers,
            'message' => 'Customers loaded successfully!'
        ]);

    }
}
