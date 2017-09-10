<?php

namespace App\Filters;

use App\MatchEntry;
use Illuminate\Http\Request;

class MatchEntryFilters extends QueryFilters
{

    /**
     * Search by Type Sport
     */
    public function whereTypeSport($id){
    	
        return $this->builder->where('typesport_id', $id);
    }
}