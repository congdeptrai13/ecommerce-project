<?php

namespace App\DataTables;

use App\Models\VariantItem;
use App\Models\VendorProductVariantItem;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class VendorProductVariantItemDataTable extends DataTable
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
                return "
<a href='" . route('vendor.product-variant-item.edit', $query->id) . "' class='btn btn-primary'><i class='fas fa-edit'></i></a>
<a href='" . route('vendor.product-variant-item.destroy', $query->id) . "' class='btn btn-danger delete-item'><i class='fas fa-trash'></i></a>
";
            })
            ->addColumn('status', function ($query) {
                if ($query->status === 1) {
                    return '
                    <div class="form-check form-switch">
                    <input class="form-check-input change-status" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked data-id="' . $query->id . '" name="custom-switch-checkbox" data-id="' . $query->id . '">
                  </div>
          ';
                } else {
                    return '
                    <div class="form-check form-switch">
                    <input class="form-check-input change-status" type="checkbox" role="switch" id="flexSwitchCheckChecked" data-id="' . $query->id . '" name="custom-switch-checkbox" data-id="' . $query->id . '">
                  </div>
          ';
                }
            })
            ->addColumn('Variant Name', function ($query) {
                return $query->variant->name;
            })
            ->addColumn("is_default", function ($query) {
                if ($query->is_default === 1) {
                    return "<i class='badge bg-info'>Default</i>";
                } else {
                    return "<i class='badge bg-danger'>No</i>";
                }
            })
            ->rawColumns(['action', 'status', 'Variant Name', 'is_default'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(VariantItem $model): QueryBuilder
    {
        return $model->where('product_variant_id', request()->variantId)->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('vendorproductvariantitem-table')
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
            Column::make('name'),
            Column::make('Variant Name'),
            Column::make('price'),
            Column::make('is_default'),
            Column::make('status'),
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
        return 'VendorProductVariantItem_' . date('YmdHis');
    }
}
