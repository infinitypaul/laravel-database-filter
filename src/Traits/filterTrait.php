<?php

namespace Infinitypaul\LaravelDatabaseFilter\Traits;

use Exception;
use Illuminate\Database\Eloquent\Builder;

trait filterTrait
{
    public function scopeFilter(Builder $builder, $request, array $filters = [])
    {
        if (empty($this->filter)) {
            throw new Exception('protected $filter Not Found In '.get_class($this));
        }
        $filters = is_array($this->filter) ? $this->filter : [$this->filter];


        foreach ($filters as $filter){
            return (new $filter($request))->add($filters)->filter($builder);
        }

    }




}
