<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BranchSport;
use App\KindSport;
use App\TypeSport;

class PageController extends Controller
{
    //
    public function sportSummary()
    {
    	$countBranchSports = BranchSport::all()->count();
    	$countKindSports = KindSport::all()->count();
    	$countTypeSports = TypeSport::all()->count();

    	return view('page.sport-summary', compact('countBranchSports', 'countKindSports', 'countTypeSports'));
    }
}
