<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Filters\MatchEntryFilters;
use Yajra\Datatables\Facades\Datatables;
use App\Traits\StringTrait;
use DB;
use App\MatchEntry;

class MatchEntryController extends Controller
{
	use StringTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.matchentries');
    }

    /**
     * Data for DataTables
     *
     * @return \Illuminate\Http\Response
     */
    public function masterDataTable(){

        $data = MatchEntry::where('match_entries.deleted_at', null)
                    ->join('type_sports', 'match_entries.typesport_id', '=', 'type_sports.id')                
                    ->select('match_entries.*', 'type_sports.name as typesport_name', 'type_sports.gender_type as gender_type')->get();

        return $this->makeTable($data);
    }

    // Data for DataTables with Filters
    public function getDataWithFilters(MatchEntryFilters $filters){        
        
        /* Note : kalo nanti butuh fungsi ->get() , tinggal ->get() di variable nya aja, 
         * e.g : $data->get();
         */
        $data = MatchEntry::filter($filters)->with('typeSport')->get();

        return $data;
    }

    // Datatable template
    public function makeTable($data){

        return Datatables::of($data)
                ->editColumn('id', function ($item) {
                    return "ME".$item->id;
                })
                ->editColumn('code', function ($item) {
                    return
                    "<a class='code-label' data-id='".$item->id."' data-code='".$item->code."' style='padding: 8px;'>".$item->code."</a>";          
                })
                ->editColumn('description', function ($item) {
                    $description = $this->replaceSingleQuote($item->description);
                    return
                    "<a class='open-description-modal' data-target='#description-modal' data-toggle='modal' data-title='Match Entry Description (Code : ".$item->code.")' data-description='".$description."' style='color: black;text-decoration: none;'> ".str_limit($description, 50)." </a>";                   
                })
                ->addColumn('action', function ($item) {

                    return 
                    "<a href='#match-entry' data-id='".$item->id."' data-toggle='modal' class='btn btn-sm btn-warning edit-match-entry'><i class='fa fa-pencil'></i></a>
                    <button class='btn btn-danger btn-sm btn-delete deleteButton' data-toggle='confirmation' data-singleton='true' value='".$item->id."'><i class='fa fa-trash-o'></i></button>";
                    
                })
                ->rawColumns(['code', 'description', 'action'])
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
        // dd($request->all());        

        // $datetime = str_replace("-", "", $request['datetime']);
        // dd(Carbon::parse($datetime)->format('Y-m-d h:i:s'));

        $this->validate($request, [
            'code' => 'required',
            'typesport_id' => 'required',            
            ]);        

       	$matchentry = MatchEntry::create($request->all());
        
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
        $data = MatchEntry::with('typeSport')->where('id', $id)->first();

        return response()->json($data);
        // return view('master.form.schedule-form', compact('data'));
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
            ]);

        $schedule = MatchEntry::find($id)->update($request->all());

        return response()->json(['responseText' => 'Success!']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $schedule = MatchEntry::destroy($id);

        return response()->json($id);
    }
}
