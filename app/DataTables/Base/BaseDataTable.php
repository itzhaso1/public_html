<?php

namespace App\DataTables\Base;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Services\DataTable;

abstract class BaseDataTable extends DataTable
{
    public function __construct(protected Model $model)
    {
        $this->model = $model;
    }

    abstract protected function dataTable(QueryBuilder $query): EloquentDataTable;

    abstract protected function query();

    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId($this->model->getTable() . '_datatable')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->parameters($this->getParameters());
    }

    abstract protected function getColumns(): array;

    /**
     * ✅ إعدادات DataTable بدون Buttons
     * (حل نهائي لمشكلة اختفاء البيانات)
     */
    protected function getParameters(): array
    {
        return [
            'dom' => 'lfrtip',
            'processing' => true,
            'serverSide' => true,
            'responsive' => true,
            'language' => datatable_lang(),
        ];
    }

    protected function filename(): string
    {
        return $this->model->getTable() . '_' . date('YmdHis');
    }

    /* ================= Helpers ================= */

    protected function formatBadge($value): string
    {
        if (!$value) {
            return '<span class="badge badge-danger">'
                . trans('dashboard/datatable.no_date_found') .
                '</span>';
        }

        return '<span class="badge badge-success">' . e($value) . '</span>';
    }

    protected function formatColoredBadge(string $text, string $color = 'secondary'): string
    {
        return '<span class="badge badge-' . e($color) . '">' . e($text) . '</span>';
    }

    protected function formatStatus($status): string
    {
        $badge = $status === 'active' ? 'success' : 'secondary';
        return '<span class="badge badge-' . $badge . '">' . e($status) . '</span>';
    }

    protected function formatDate($value): string
    {
        return $value ? $value->diffForHumans() : '';
    }
}
