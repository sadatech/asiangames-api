<?php

namespace App\Filters;

use App\TypeSport;
use Illuminate\Http\Request;

class TypeSportFilters extends QueryFilters
{

    /**
     * Ordering data by name (test case)
     */
    public function name($value) {
        
        return (!$this->requestAllData($value)) ? $this->builder->where('name', 'like', '%'.$value.'%') : null;
    } 

    /**
     * Search by Kind Sport
     */
    public function whereKindSport($id){

        return $this->builder->where('kindsport_id', $id);
    }
}