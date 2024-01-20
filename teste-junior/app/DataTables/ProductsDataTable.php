<?php

namespace App\DataTables;

use App\Models\Product;
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

class ProductsDataTable extends DataTable
{
    protected Product $product;

    public function __construct(Product $product)
    {
        parent::__construct();
        $this->product = $product;
    }

    /**
     * Build DataTable class.
     *
     * @return JsonResponse
     * @throws Exception
     */
    public function dataTable(): JsonResponse
    {
        return (new EloquentDataTable($this->product::query()))
            ->filterColumn('price', function($query, $keyword) {
                $search = convertPriceToInteger($keyword);

                if ($search) $query->where("price", $search);
            })
            ->addColumn('actions', function ($product) {
                $btnEdit = '<a type="button" class="btn btn-primary" href="' . route('update_product_form', ['id' => $product->uuid]) . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                $btnDelete = '<button type="button" class="btn btn-danger" value="'.$product->uuid.'" onclick="showDeleteConfirmation('."'productId'".', this)"><i class="fa-solid fa-trash"></i></button>';
                return "<div class='text-right d-flex flex-wrap gap-2 justify-content-center w-fitcontent'>$btnEdit $btnDelete</div>";
            })
            ->rawColumns(['actions'])
            ->make();
    }
}
