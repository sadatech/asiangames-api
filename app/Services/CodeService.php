<?php
namespace App\Services;

use App\Schedule;
use App\MatchEntry;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class CodeService
{
    static function getScheduleCode(){

        $lastSchedule = Schedule::orderBy('code', 'DESC')->first();

        if(!$lastSchedule){
            return "SCH1";
        }
        
        $incrementCode = (int)(explode("SCH", $lastSchedule))[1] + 1;

        return "SCH".(string)$incrementCode;
        
    }

    static function getMatchEntryCode(){

        $lastMatchEntry = MatchEntry::orderBy('code', 'DESC')->first();

        if(!$lastMatchEntry){
            return "MTE1";
        }
        
        $incrementCode = (int)(explode("MTE", $lastMatchEntry))[1] + 1;

        return "MTE".(string)$incrementCode;
        
    }  

}