<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Schedule;
use App\MatchEntry;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public static function getMatchEntryCode(){

        $lastMatchEntry = MatchEntry::orderBy('id', 'DESC')->first();        

        if(!$lastMatchEntry){
            return "MTE1";
        }
        
        $incrementCode = (int)(explode("MTE", $lastMatchEntry->code))[1] + 1;
        $matchEntryCode = "MTE".(string)$incrementCode;

        return response()->json($matchEntryCode);        
        
    } 

    /*
     * Injection Access -> Laravel Blade
     *
     */

    static function getScheduleCode(){

        $lastSchedule = Schedule::orderBy('id', 'DESC')->first();

        if(!$lastSchedule){
            return "SCH1";
        }
        
        $incrementCode = (int)(explode("SCH", $lastSchedule->code))[1] + 1;

        return "SCH".(string)$incrementCode;
        
    }
}
