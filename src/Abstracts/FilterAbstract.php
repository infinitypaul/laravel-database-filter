<?php

namespace Infinitypaul\LaravelDatabaseFilter\Abstracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

abstract class FilterAbstract
{
    /**
     * Filter Column.
     *
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param $value
     *
     * @return mixed
     */
    abstract public function filter(Builder $builder, $value);

    public function mappings()
    {
        return [];
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param $key
     *
     * @return \Illuminate\Database\Eloquent\Builder|mixed
     */
    public function resolveFilterValue(Builder $builder, $key)
    {
        if (class_exists(Arr::class)) {
            $value = empty($this->mappings()) ? $key : Arr::get($this->mappings(), $key);
        } else {
            $value = empty($this->mappings()) ? $key : array_get($this->mappings(), $key);
        }

        if ($value === null) {
            return $builder;
        }

        return $this->filter($builder, $value);
    }
}
