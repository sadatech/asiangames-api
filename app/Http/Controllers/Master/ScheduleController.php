<?php

namespace App\Http\Controllers\Master;

use App\Schedule;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Filters\ScheduleFilters;
use App\Traits\StringTrait;
use DB;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    use StringTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.schedules');
    }

    /**
     * Data for DataTables
     *
     * @return \Illuminate\Http\Response
     */
    public function masterDataTable(){

        $data = Schedule::where('schedules.deleted_at', null)
                    ->join('type_sports', 'schedules.typesport_id', '=', 'type_sports.id')
                    ->select('schedules.*', 'type_sports.name as typesport_name')->get();

        return $this->makeTable($data);
    }

    // Data for DataTables with Filters
    public function getDataWithFilters(ScheduleFilters $filters){        
        
        /* Note : kalo nanti butuh fungsi ->get() , tinggal ->get() di variable nya aja, 
         * e.g : $data->get();
         */
        $data = Schedule::filter($filters)->with('typeSport')->get();

        return $data;
    }

    // Datatable template
    public function makeTable($data){

        return Datatables::of($data)
                ->editColumn('datetime', function ($item){
                    return $this->convertDateTime($item->datetime);
                })
                ->editColumn('description', function ($item) {
                    $description = $this->replaceSingleQuote($item->description);
                    return
                    "<a class='open-description-modal' data-target='#description-modal' data-toggle='modal' data-title='Schedule Description (Code : ".$item->code.")' data-description='".$description."' style='color: black;text-decoration: none;'> ".str_limit($description, 50)." </a>";                   
                })
                ->addColumn('action', function ($item) {

                    return 
                    "<a href='".url('schedules/edit/'.$item->id)."' class='btn btn-sm btn-warning'><i class='fa fa-pencil'></i></a>
                    <button class='btn btn-danger btn-sm btn-delete deleteButton' data-toggle='confirmation' data-singleton='true' value='".$item->id."'><i class='fa fa-trash-o'></i></button>";
                    
                })
                ->rawColumns(['description', 'action'])
                ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.form.schedule-form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {    	
        // dd($request->all());        

        // $datetime = str_replace("-", "", $request['datetime']);
        // dd(Carbon::parse($datetime)->format('Y-m-d h:i:s'));

        $this->validate($request, [
            'code' => 'required',
            'typesport_id' => 'required',
            'datetime' => 'required',
            ]);

        // Convert string from DateTimePicker to datetime
        $datetime = $this->replaceDash($request['datetime']);
        $request['datetime'] = Carbon::parse($datetime)->format('Y-m-d H:i:s');

       	$schedule = Schedule::create($request->all());
        
        return response()->json(['responseText' => 'Success!', 'url' => url('/schedules')]);
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
        $data = Schedule::where('id', $id)->first();

        return view('master.form.schedule-form', compact('data'));
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
        $this->validate($request, [
            'code' => 'required',
            'typesport_id' => 'required',
            'datetime' => 'required',
            ]);

        // Convert string from DateTimePicker to datetime
        $datetime = $this->replaceDash($request['datetime']);
        $request['datetime'] = Carbon::parse($datetime)->format('Y-m-d H:i:s');

        $schedule = Schedule::find($id)->update($request->all());

        return response()->json(
            [
                'responseText' => 'Success!', 
                'url' => url('/schedules'),
                'method' => $request->_method
            ]);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = Schedule::destroy($id);

        return response()->json($id);
    }
}
