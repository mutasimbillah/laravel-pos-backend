<?php

namespace App\Filters;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

/**
 * Base filter class for creating filterable resources
 * @author Nazmul Alam <nazmulpcc@gmail.com>
 */
abstract class Filter {
    /**
     * @var Builder
     */
    protected $query;

    /**
     * @var array
     */
    protected $filters;

    /**
     * @var array|string[]
     */
    protected $allowedSorts = ['id', 'created_at'];

    protected $allowedRelations = ['creator', 'organization'];

    /**
     * Default filters
     *
     * @var array
     */
    protected $defaults = [];

    public function filters(array $filters) {
        $this->filters = $filters;
        return $this;
    }

    public function defaults(array $defaults) {
        $this->defaults = $defaults;
        return $this;
    }

    /**
     * Get base query object
     *
     * @return Builder
     */
    abstract public function getQuery();

    public static function new (Builder &$query = null) {
        $instance = new static();
        if (!$query) {
            $query = $instance->getQuery();
        }
        return $instance->on($query);
    }

    public function on(&$query) {
        $this->query = $query;
        return $this;
    }

    public function apply() {
        if (!isset($this->filters)) {
            $this->filters = request()->all();
        }

        $this->filters = array_filter(array_merge($this->defaults, $this->filters));

        foreach ($this->filters as $filter => $value) {
            list($filter, $value) = $this->normalizeFilterValue($filter, $value);
            if (method_exists($this, $filter)) {
                $this->{$filter}($value);
            }
        }
        return $this->query;
    }

    public function get() {
        return $this->apply()->get();
    }

    public function first() {
        return $this->get()->first();
    }

    /**
     * A default sort filter that can be applied anywhere
     * @param $column
     * @return false|void
     */
    protected function sort($column) {
        if (in_array($column, $this->allowedSorts)) {
            $this->query->orderBy($this->query->getQuery()->from . ".{$column}", $this->filters['order'] ?? 'desc');
        }
    }

    protected function with($relations) {
        $relations = array_intersect($this->allowedRelations, explode(',', $relations));
        $this->query->with($relations);
    }

    /**
     * Normalize filter key value
     * If the filter itself is numeric, it means we received an associative array
     * So the key should be the given value and value is by default false
     * @param $filter
     * @param $value
     * @return array
     */
    protected function normalizeFilterValue($filter, $value) {
        if (is_numeric($filter)) {
            $filter = $value;
            $value = true;
        }
        if ($value === 'true') {
            $value = true;
        }
        if ($value === 'false') {
            $value = false;
        }
        return [$filter, $value];
    }
}
