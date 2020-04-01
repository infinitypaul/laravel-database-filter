<?php


namespace Infinitypaul\LaravelDatabaseFilter\Abstracts;


use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class FiltersAbstract
{
    protected $request;

    protected $filters = [];

    public function __construct(Request $request)
    {

        $this->request = $request;
    }

    public function filter(Builder $builder){
        foreach ($this->getFilters() as $filter => $value){
            $this->resolveFilter($filter)->resolveFilterValue($builder, $value);

        }
        return $builder;
    }

    public function add(array $filters){
         $this->filters = array_merge($this->filters, $filters);
         return $this;
    }

    protected function getFilters(){
        return $this->filterFilters($this->filters);
    }

    protected function filterFilters($filters){
        return array_filter($this->request->only(array_keys($this->filters)));
    }

    protected function resolveFilter($filter){
        return new $this->filters[$filter];
    }
}
