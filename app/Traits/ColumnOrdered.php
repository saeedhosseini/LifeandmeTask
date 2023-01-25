<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Str;

trait ColumnOrdered
{

    private array $columns;

    public function __construct()
    {
        $this->columns = $this->getTableColumns();
    }

    /**
     * order query
     *
     * @param Builder $q
     * @param array $data
     * @return Builder query that ordered
     */
    public function scopeOrderedByColumn(Builder $q, array $data): Builder
    {
        $validData = array_filter($data, [$this, 'getValidColumn'], ARRAY_FILTER_USE_BOTH);
        foreach ($validData as $key => $c) {
            $q = $q->orderBy(substr($key,2), Str::lower($c));
        }
        return $q;
    }

    //filter valid data send for order
    private function getValidColumn($item, $key): bool
    {
        return in_array(substr($key,2), $this->columns) && ($item == 'DESC' || $item == 'ASC');
    }


    private function getTableColumns(): array
    {
        return $this->getConnection()->getSchemaBuilder()->getColumnListing($this->getTable());
    }

}
