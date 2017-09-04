<?php

namespace App\Filters;

use App\BrachSport;
use Illuminate\Http\Request;


class BranchSportFilters extends QueryFilters
{

    /**
     * Ordering data by name (test case)
     */
    public function name($value) {
        // return $this->builder->where('name', 'like', '%'.$value.'%');        
        return (!$this->requestAllData($value)) ? $this->builder->where('name', 'like', '%'.$value.'%') : null;
    } 
}