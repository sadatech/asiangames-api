<?php

namespace App\Filters;

use App\Schedule;
use App\TypeSport;
use App\MatchEntry;
use Illuminate\Http\Request;

class ScheduleFilters extends QueryFilters
{

    /**
     * Search by Type Sport
     */
    public function whereTypeSport($id){
    	
        return $this->builder->where('typesport_id', $id);
    }

    /**
     * Search by Code and description
     */
    public function code($value) {
        
        $builderCode = clone $this->builder;
        $builderDesc = clone $this->builder;

        if (!$this->requestAllData($value)) { 

            if($builderCode->where('code', 'like', '%'.$value.'%')->count() > 0){               
                return $this->builder->where('code', 'like', '%'.$value.'%');
            }

            /* Use if there is 3rd or more parameter to be a search term */
            if($builderDesc->where('description', 'like', '%'.$value.'%')->count() > 0){                             
             return $this->builder->where('description', 'like', '%'.$value.'%');
            }

            $typeSportIds = TypeSport::where('name', 'like', '%'.$value.'%')->pluck('id');
            return $this->builder->whereIn('typesport_id', $typeSportIds);
        }


    }

    /**
     * Search by Type Sport => input Match Entry
     */
    public function byTypeSportScheduleFromMatchEntry($matchEntryIds){

        $typeSportIds = MatchEntry::whereIn('id', $matchEntryIds)->pluck('typesport_id');
        
        return $this->builder->whereIn('typesport_id', $typeSportIds);
    }

}