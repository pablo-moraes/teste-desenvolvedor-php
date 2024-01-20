<?php

namespace App\DataTables;

use App\Models\Customer;
use Exception;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CustomersDataTable extends DataTable
{

    protected Customer $customer;

    public function __construct(Customer $customer)
    {
        parent::__construct();
        $this->customer = $customer;
    }

    /**
     * Build DataTable class.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function dataTable(): JsonResponse
    {
        return (new EloquentDataTable($this->customer::query()))
            ->addColumn('actions', function ($customer) {
                $btnEdit = '<a type="button" class="btn btn-primary" href="' . route('update_customer_form', ['id' => $customer->uuid]) . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                $btnDelete = '<button type="button" class="btn btn-danger" value="' . $customer->uuid . '" onclick="showDeleteConfirmation('."'customerId'".',  this)"><i class="fa-solid fa-trash"></i></button>';
                return "<div class='text-right d-flex flex-wrap gap-2 justify-content-center'>$btnEdit $btnDelete</div>";
            })
            ->rawColumns(['actions'])
            ->make();
    }
}
