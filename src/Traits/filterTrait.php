<?php

namespace Infinitypaul\LaravelDatabaseFilter\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;

trait filterTrait
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $builder
     * @param $request
     * @param \Infinitypaul\LaravelDatabaseFilter\Traits\string|string $filterClass
     * @param array $filters
     *
     * @return mixed
     * @throws \Exception
     *
     * @method static mixed filter($request, string $filterClass='', array $filters)
     */
    public function scopeFilter(Builder $builder, $request,  $filterClass='', array $filters = [])
    {
        if (empty($this->filter)) {
            throw new Exception('protected $filter Not Found In '.get_class($this));
        }
        if(empty($filterClass)){
            return (new $this->filter($request))->add($filters)->filter($builder);
        }
            return (new $filterClass($request))->add($filters)->filter($builder);
    }
}
