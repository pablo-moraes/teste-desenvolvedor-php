<?php

namespace App\DataTables;

use App\Models\Order;
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

class OrdersDataTable extends DataTable
{

    protected Order $order;

    /**
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        parent::__construct();
        $this->order = $order;
    }

    /**
     * Build DataTable class.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function dataTable(): JsonResponse
    {

        $orderQuery = $this->order->with([
            'customer:uuid,name',
            'product:uuid,name,price'
        ])->select('orders.*');


        return (new EloquentDataTable($orderQuery))
            ->filterColumn('total_price', fn($query, $keyword) => $this->filterTotalPrice($query, $keyword))
            ->filterColumn('product.name', fn($query, $keyword) => $this->filterProductName($query, $keyword))
            ->filterColumn('customer.name', fn($query, $keyword) => $this->filterCustomerName($query, $keyword))
            ->addColumn('actions', function ($order) {
                $btnEdit = '<a type="button" class="btn btn-primary" href="' . route('update_order_form', ['id' => $order->uuid]) . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                $btnDelete = '<button type="button" class="btn btn-danger" value="' . $order->uuid . '" onclick="showDeleteConfirmation(' . "'orderId'" . ', this)"><i class="fa-solid fa-trash"></i> </button>';
                return "<div class='text-right d-flex flex-wrap gap-2 justify-content-center'>$btnEdit $btnDelete</div>";
            })
            ->addColumn('total_price', function ($order) {
                return $order->total_price;
            })
            ->rawColumns(['actions'])
            ->make();
    }

    /**
     * @param mixed $query
     * @param string $keyword
     */
    private function filterTotalPrice(mixed $query, string $keyword): void
    {
        $search = convertPriceToInteger($keyword);

        if ($search) {
            $query->whereHas('product', fn($subQuery) => $subQuery->whereRaw("(quantity * products.price) like ?", ["%$search%"]));
        }
    }

    /**
     * @param mixed $query
     * @param string $keyword
     */
    private function filterCustomerName(mixed $query, string $keyword): void
    {
        $query->whereHas('customer', fn($subQuery) => $subQuery->whereRaw("customers.name like ?", ["%$keyword%"]));
    }

    /**
     * @param mixed $query
     * @param string $keyword
     */
    private function filterProductName(mixed $query, string $keyword): void
    {

        $query->whereHas('product', fn($subQuery) => $subQuery->whereRaw("products.name like ?", ["%$keyword%"]));
    }
}
