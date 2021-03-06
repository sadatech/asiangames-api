<?php

namespace App\Filters;

use App\KindSport;
use Illuminate\Http\Request;

class KindSportFilters extends QueryFilters
{

    /**
     * Ordering data by name (test case)
     */
    public function name($value) {
        // return $this->builder->where('name', 'like', '%'.$value.'%');
        return (!$this->requestAllData($value)) ? $this->builder->where('name', 'like', '%'.$value.'%') : null;
    } 

    /**
     * Search by Branch Sport
     */
    public function whereBranchSport($id){
    	
        return $this->builder->where('branchsport_id', $id);
    }
}