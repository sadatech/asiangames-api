<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BranchSport;
use App\KindSport;
use App\TypeSport;

class RelationController extends Controller
{
    //
    public function branchKindRelation(Request $request){
    	$countKindSport = KindSport::where('branchsport_id', $request->branchSportId)->count();

        return $countKindSport;
    }

    public function kindTypeRelation(Request $request){
    	$countTypeSport = TypeSport::where('kindsport_id', $request->kindSportId)->count();

        return $countTypeSport;
    }

}
