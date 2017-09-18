<?php

namespace App\Filters;

use App\MatchEntry;
use App\Schedule;
use App\TypeSport;
use App\ScheduleDetail;
use Illuminate\Http\Request;

class MatchEntryFilters extends QueryFilters
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
     * Search by Type Sport => input Schedule Id
     */
    public function byTypeSportSchedule($scheduleId){

    	$typeSportId = Schedule::find($scheduleId)->typesport_id;    	
    	
        return $this->builder->where('typesport_id', $typeSportId);
    }

    /**
     * Search by Type Sport => input Match Entry
     */
    public function byTypeSportMatchEntry($matchEntryIds){

    	$typeSportIds = MatchEntry::whereIn('id', $matchEntryIds)->pluck('typesport_id');
    	
        return $this->builder->whereIn('typesport_id', $typeSportIds);
    }

    /**
     * Search by not in id match entry
     */
    public function notWIthId($matchEntryIds){    	
    	
        return $this->builder->whereNotIn('id', $matchEntryIds);
    }

    /**
     * Search by Type Sport Name
     */
    public function byTypeSportName($value){

    	if (!$this->requestAllData($value)) {      
        	$typeSportIds = TypeSport::where('name', 'like', '%'.$value.'%')->pluck('id');
        	$this->builder->whereIn('typesport_id', $typeSportIds);
        }

        return $this->builder;

    }

    /**
     * Search by not in id in schedule details
     */
    public function notInScheduleDetail($scheduleId){      
        
        $matchEntryIds = ScheduleDetail::where('schedule_id', $scheduleId)->pluck('matchentry_id');

        // dd($matchEntryIds);

        return $this->builder->whereNotIn('id', $matchEntryIds);
    }

}