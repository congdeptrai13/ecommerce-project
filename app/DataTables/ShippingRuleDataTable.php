<?php

namespace App\DataTables;

use App\Models\GeneralSetting;
use App\Models\ShippingRule;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ShippingRuleDataTable extends DataTable
{
    protected $currency = "";
    public function __construct() {
        $this->currency = GeneralSetting::first()->currency_icon;
    }
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
            <a href='" . route('admin.shipping-rule.edit', $query->id) . "' class='btn btn-primary'><i class='fas fa-edit'></i></a>
            <a href='" . route('admin.shipping-rule.destroy', $query->id) . "' class='btn btn-danger delete-item'><i class='fas fa-trash'></i></a>
            ";
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
            ->addColumn("type", function ($query) {
                if ($query->type === 'min_cost') {
                    return "<i class='badge badge-primary'>Mininum Order Amount</i>";
                } else {
                    return "<i class='badge badge-success'>Flat Amount</i>";
                }
            })
            ->addColumn("min_cost", function ($query) {
                if ($query->type === 'min_cost') {
                    return $this->currency . $query->min_cost;
                } else {
                    return $this->currency . '0';
                }
            })
            ->addColumn("cost", function ($query) {

                    return $this->currency . $query->cost;
            })
            ->rawColumns(['action','status','type'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(ShippingRule $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('shippingrule-table')
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
            Column::make('type'),
            Column::make('min_cost'),
            Column::make('cost'),
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
        return 'ShippingRule_' . date('YmdHis');
    }
}
