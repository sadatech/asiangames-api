<?php

namespace App\Filters;

use App\MatchGroup;
use Illuminate\Http\Request;

class MatchGroupFilters extends QueryFilters
{

    /**
     * Search by Match Entry
     */
    public function whereMatchEntry($id){
    	
        return $this->builder->where('matchentry_id', $id);
    }

    /**
     * Search by Athlete
     */
    public function whereAthlete($id){
    	
        return $this->builder->where('athlete_id', $id);
    }
}