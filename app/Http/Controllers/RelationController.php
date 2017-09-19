<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BranchSport;
use App\KindSport;
use App\TypeSport;
use App\Athlete;
use App\MatchEntry;
use App\MatchGroup;
use App\Schedule;
use App\ScheduleDetail;

class RelationController extends Controller
{
    //
    public function branchKindRelation(Request $request){
    	$countKindSport = KindSport::where('branchsport_id', $request->branchSportId)->count();

        return response()->json($countKindSport);
    }

    public function kindTypeRelation(Request $request){
    	$countTypeSport = TypeSport::where('kindsport_id', $request->kindSportId)->count();

        return response()->json($countTypeSport);
    }

    public function countryAthleteRelation(Request $request){
    	$countAthletes = Athlete::where('country_id', $request->countryId)->count();

        return response()->json($countAthletes);
    }

    public function typeMatchRelation(Request $request){
        $countMatchEntry = MatchEntry::where('typesport_id', $request->typeSportId)->count();

        return response()->json($countMatchEntry);
    }

    public function typeScheduleRelation(Request $request){
        $countSchedule = Schedule::where('typesport_id', $request->typeSportId)->count();

        return response()->json($countSchedule);
    }

    public function typeAthleteRelation(Request $request){
        $countAthlete = Athlete::where('typesport_id', $request->typeSportId)->count();

        return response()->json($countAthlete);
    }

    public function athleteMatchGroupRelation(Request $request){
        $countMatchGroup = MatchGroup::where('athlete_id', $request->athleteId)->count();

        return response()->json($countMatchGroup);
    }

    public function matchEntryMatchGroupRelation(Request $request){
        $countMatchGroup = MatchGroup::where('matchentry_id', $request->matchEntryId)->count();

        return response()->json($countMatchGroup);
    }    

    public function matchEntryScheduleDetailsRelation(Request $request){
        $countScheduleDetails = ScheduleDetail::where('matchentry_id', $request->matchEntryId)->count();

        return response()->json($countScheduleDetails);
    }    

    public function scheduleScheduleDetailsRelation(Request $request){
        $countScheduleDetails = ScheduleDetail::where('schedule_id', $request->scheduleId)->count();

        return response()->json($countScheduleDetails);
    }   
}
