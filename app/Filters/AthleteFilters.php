<?php

namespace App\Filters;

use App\Athlete;
use App\MatchGroup;
use Illuminate\Http\Request;

class AthleteFilters extends QueryFilters
{

    /**
     * Ordering data by name (test case)
     */
    public function name($value) {
        // return $this->builder->where('name', 'like', '%'.$value.'%');
        return (!$this->requestAllData($value)) ? $this->builder->where('firstname', 'like', '%'.$value.'%')->orWhere('lastname', 'like', '%'.$value.'%') : null;
    }

    /**
     * Where athlete not in match entry
     */
    public function notInMatchEntry($id) {    
    	$matchGroupAthleteIds = MatchGroup::where('matchentry_id', $id)->pluck('athlete_id');
    	// dd($matchGroupAthleteIds);
        return $this->builder->whereNotIn('id', $matchGroupAthleteIds);
    }
}
