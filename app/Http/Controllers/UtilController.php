<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ScheduleDetail;

class UtilController extends Controller
{
    //
    public function checkScheduleDetail(Request $request){
    	$countScheduleDetail = ScheduleDetail::where('schedule_id', $request->scheduleId)->count();

        return response()->json($countScheduleDetail);
    }
}
