<?php


namespace Infinitypaul\LaravelDatabaseFilter\Traits;


use Exception;
use Illuminate\Database\Eloquent\Builder;

trait filterTrait
{

    public function scopeFilter(Builder $builder, $request, array $filters = []){
        if(empty($this->filter)){
            throw new Exception('protected $filter Not Found In '.get_class($this));
        }
        return (new $this->filter($request))->add($filters)->filter($builder);
    }
}
