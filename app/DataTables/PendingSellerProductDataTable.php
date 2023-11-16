<?php

namespace App\DataTables;

use App\Models\PendingSellerProduct;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class PendingSellerProductDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($query) {
                $other_btn = '<div class="dropleft d-inline">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-cog"></i>
            </button>
            <div class="dropdown-menu">
              <a class="dropdown-item has-icon" href="' . route('admin.product-images-gallery.index', ['product' => $query->id]) . '"><i class="far fa-heart"></i> Image Gallery</a>
              <a class="dropdown-item has-icon" href="' . route('admin.product-variant.index', ['product' => $query->id]) . '"><i class="far fa-file"></i> Variant</a>
            </div>
          </div>';
                return "
<a href='" . route('admin.products.edit', $query->id) . "' class='btn btn-primary'><i class='fas fa-edit'></i></a>
<a href='" . route('admin.products.destroy', $query->id) . "' class='btn btn-danger delete-item'><i class='fas fa-trash'></i></a>
" . $other_btn;
            })
            ->addColumn('vendor', function ($query) {
                return $query->vendor->shop_name;
            })
            ->addColumn('image', function ($query) {
                return "<img width='70px' src='" . asset($query->thumb_image) . "'/>";
            })
            ->addColumn("type", function ($query) {
                switch ($query->product_type) {
                    case "new_arrival":
                        return "<i class='badge badge-info'>New Arrival</i>";
                    case "featured":
                        return "<i class='badge badge-info'> Featured</i>";

                    case "top_product":
                        return "<i class='badge badge-info'> Top Product</i>";
                    case "best_product":
                        return "<i class='badge badge-info'>Best Product</i>";
                    default:
                        return "<i class='badge badge-dark'>None</i>";
                }
            })
            ->addColumn('status', function ($query) {
                if ($query->status === 1) {
                    return '
            <label class="custom-switch mt-2">
            <input type="checkbox" checked data-id="' . $query->id . '" name="custom-switch-checkbox" class="custom-switch-input change-status">
            <span class="custom-switch-indicator"></span>
          </label>
          ';
                } else {
                    return '
            <label class="custom-switch mt-2">
            <input type="checkbox" data-id="' . $query->id . '"  name="custom-switch-checkbox" class="custom-switch-input change-status">
            <span class="custom-switch-indicator"></span>
          </label>
          ';
                }
            })

            ->addColumn('approved', function ($query) {
                return
                    '
                    <select class="form-control is_approve" data-id="' . $query->id . '">
                        <option value="0">Pending</option>
                        <option value="1">Approved</option>
                    </select>
                ';
            })
            ->rawColumns(['action', 'status', 'image', 'type', 'approved'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Product $model): QueryBuilder
    {
        return $model
            ->where('vendor_id', "!=", Auth::user()->vendor->id)
            ->where('is_approved', 0)
            ->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('pendingsellerproduct-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            //->dom('Bfrtip')
            ->orderBy(1)
            ->selectStyleSingle()
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [

            Column::make('id'),
            Column::make('vendor'),
            Column::make('image'),
            Column::make('name'),
            Column::make('price'),
            Column::make('type'),
            Column::make('status'),
            Column::make('approved')->width(100),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(200)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'PendingSellerProduct_' . date('YmdHis');
    }
}
