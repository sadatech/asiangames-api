<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Filters\ScheduleFilters;
use App\Traits\StringTrait;
use DB;
use Carbon\Carbon;
use App\ScheduleDetail;
use App\Schedule;
use App\MatchEntry;
use App\MatchGroup;
use App\Athlete;

class ScheduleDetailController extends Controller
{
    //
    use StringTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.scheduledetails');
    }

    /**
     * Data for DataTables
     *
     * @return \Illuminate\Http\Response
     */
    public function masterDataTable(){

        $data = ScheduleDetail::where('schedule_details.deleted_at', null)
        			// ->join('schedules', 'schedule_details.schedule_id', '=', 'schedules.id')
                    // ->join('match_entries', 'schedule_details.matchentry_id', '=', 'match_entries.id')
                    ->select('schedule_details.*')->distinct()->get(['schedule_id']);

        $dataDistinct = ScheduleDetail::distinct()->get(['schedule_id']);

        $data = ScheduleDetail::where('schedule_details.deleted_at', null)
        			->join('schedules', 'schedule_details.schedule_id', '=', 'schedules.id')
                    // ->join('match_entries', 'schedule_details.matchentry_id', '=', 'match_entries.id')                    
                    ->select('schedule_details.*', 'schedules.code as schedule_code', 'schedules.description as schedule_description')->distinct()->get(array('schedule_details.schedule_id'));

        $ddt = DB::table('schedule_details')
        		->join('schedules', 'schedule_details.schedule_id', '=', 'schedules.id')
        		->join('type_sports', 'schedules.typesport_id', '=', 'type_sports.id')
        		// ->select(array('*','schedules.code AS schedule_code'))
        		// ->groupBy('schedule_details.schedule_id')
        		->distinct('schedule_id')
        		->where('schedule_details.deleted_at', null)
        		->get(['schedules.*', 'type_sports.name as typesport']);

        // dd($ddt);

        return $this->makeTable($ddt);
    }

    // Data for DataTables with Filters
    public function getDataWithFilters(ScheduleDetailFilters $filters){        
        
        /* Note : kalo nanti butuh fungsi ->get() , tinggal ->get() di variable nya aja, 
         * e.g : $data->get();
         */
        $data = ScheduleDetail::filter($filters)->get();

        return $data;
    }

    // Datatable template
    public function makeTable($data){

    	// (Di setiap row make/edit ngefetch schedule & match entry karena ngambil datanya dari distinct)

    	
		// $dd = '<button>button 1</button>';

        return Datatables::of($data)
                ->editColumn('datetime', function ($item) {
                    return $this->convertDateTime($item->datetime);
                })
                ->editColumn('matchentry_description', function ($item) {
                    // return "MATCH ENTRY MATCH ENTRY MATCH ENTRY";

                	$matchEntryIds = ScheduleDetail::where('schedule_id', $item->id)->pluck('matchentry_id');
                	$matchEntries = MatchEntry::whereIn('id', $matchEntryIds)->get();
                    $matchGroups = MatchGroup::whereIn('matchentry_id', $matchEntryIds);                    

                    // dd($matchEntries->get());

                    $matchEntryContent = "";

                    foreach ($matchEntries as $data) {

                    $description = $this->replaceSingleQuote($data->description);

                    $matchEntryContent .= '<div class="portlet box purple" style="margin-bottom: 5px;">'.
				                                '<div class="portlet-title">'.
				                                    '<div class="caption">'.
				                                        '<span style="font-size: 14px;"> '.$data->code.' - '.str_limit($description, 50).' </span> </div>'.
				                                    '<div class="tools">'.
				                                        '<a href="" class="expand" data-original-title="" title=""> </a>'.
				                                    '</div>'.
				                                '</div>'.
				                                '<div class="portlet-body" style="display: none;">'.
				                                 	'<button>AAAA</button>'.
				                                '</div>'.
				                            '</div>';
                    }

                    

					foreach ($matchEntries as $data) {						
					            
					// $matchEntryContent .= '<div>
					// 						<button style="width: 100%; margin: 0;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#'.$data->code.'">'.$data->code.' - '.str_limit($description, 50).'</button>
					// 						<div id="'.$data->code.'" class="collapse" style="padding: 20px;">
					// 							<button>AAAA</button>
					// 						</div>
					// 					</div>';

                    }

                    $match = '<div>
                    		<button style="width: 100%; margin: 0;" type="button" class="btn btn-primary" data-toggle="collapse" data-target="#demo">Simple collapsible</button>';
                    $match .= '<div id="demo" class="collapse" style="padding: 20px;"><button>AAAA</button></div></div>';


                    $dd = '<button>OK</button>';
                    return $matchEntryContent;
                })
                ->editColumn('description', function ($item) {

                    $description = $this->replaceSingleQuote($item->description);
                    return
                    "<a class='open-description-modal' data-target='#description-modal' data-toggle='modal' data-title='Match Entry Description (Code : ".$item->code.")' data-description='".$description."' style='color: black;text-decoration: none;'> ".str_limit($description, 50)." </a>";

                })
                ->addColumn('action', function ($item) {

                    return 
                    "<button style='height: 40px; width: 40px;' class='btn btn-danger btn-sm btn-delete deleteButton' data-toggle='confirmation' data-singleton='true' value='".$item->id."'><i class='fa fa-trash-o'></i></button>";
                    
                })
                ->rawColumns(['description', 'matchentry_description', 'action'])
                ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    	

        $this->validate($request, [
            'schedule_id' => 'required',
            'matchentry_id' => 'required',            
            ]);        

        // dd($request->all());

        foreach ($request['matchentry_id'] as $id) {

        	ScheduleDetail::create([
				'schedule_id' => $request['schedule_id'],
				'matchentry_id' => $id,
			]);

        }   	
        
        return response()->json(['responseText' => 'Success!']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	//
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    	//
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $scheduleDetails = ScheduleDetail::where('schedule_id', $id)->delete();

        return response()->json($id);
    }
}
