<?php

namespace App\Filters;

use App\Schedule;
use Illuminate\Http\Request;

class ScheduleFilters extends QueryFilters
{

    /**
     * Ordering data by name (test case)
     */
    public function name($value) {
        // return $this->builder->where('name', 'like', '%'.$value.'%');
        return (!$this->requestAllData($value)) ? $this->builder->where('name', 'like', '%'.$value.'%') : null;
    } 

    /**
     * Search by Type Sport
     */
    public function whereTypeSport($id){
    	
        return $this->builder->where('typesport_id', $id);
    }
}