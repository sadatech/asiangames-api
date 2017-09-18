<?php

namespace App\Filters;

use App\Athlete;
use App\MatchGroup;
use App\MatchEntry;
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

        $matchEntry = MatchEntry::find($id);
        $typeSportId = $matchEntry->typeSport->id;
        $genderType = $matchEntry->typeSport->gender_type;        

    	$matchGroupAthleteIds = MatchGroup::where('matchentry_id', $id)->pluck('athlete_id');

        $query = clone $this->builder;

        if($genderType == 'MIXED'){

            $query = $this->builder->where('typesport_id', $typeSportId)
                                   ->whereNotIn('id', $matchGroupAthleteIds);

        }else{

            $query = $this->builder->where('typesport_id', $typeSportId)
                                   ->where('gender_type', $genderType)
                                   ->whereNotIn('id', $matchGroupAthleteIds);
        }

        return $query;
    }
}
