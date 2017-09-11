<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Filters\MatchGroupFilters;
use Yajra\Datatables\Facades\Datatables;
use App\Traits\StringTrait;
use DB;
use App\MatchGroup;

class MatchGroupController extends Controller
{
    use StringTrait;

    /**
     * Data for DataTables
     *
     * @return \Illuminate\Http\Response
     */
    public function masterDataTable(Request $request){    	

        $data = MatchGroup::where('match_groups.deleted_at', null)
        			->join('match_entries', 'match_groups.matchentry_id', '=', 'match_entries.id')
                    ->join('athletes', 'match_groups.athlete_id', '=', 'athletes.id')
                    ->join('countries', 'athletes.country_id','=', 'countries.id')
                    ->select('match_groups.*', DB::raw('CONCAT(athletes.firstname, " ", athletes.lastname) as fullname'), DB::raw('CONCAT("(", countries.code, ") ", countries.name) as country'))
        			->get();

        // If there is request for match group by match entry
        if($request['matchentry_id']){
        	$data = $data->where('matchentry_id', $request['matchentry_id']);
        }

        return $this->makeTable($data);
    }


    // Data with Filters
    public function getDataWithFilters(MatchGroupFilters $filters){        
        
        /* Note : kalo nanti butuh fungsi ->get() , tinggal ->get() di variable nya aja, 
         * e.g : $data->get();
         */       
        $data = MatchGroup::filter($filters)->get();

        return $data;
    }

    // Datatable template
    public function makeTable($data){

        return Datatables::of($data)
        		->editColumn('id', function ($item) {
        			return "MG".$item->id;
        		})
                ->editColumn('code', function ($item) {
                    return
                    "<a class='code-label' data-code='".$item->code."' style='padding: 8px;'>".$item->code."</a>";          
                })
                ->addColumn('action', function ($item) {

                    return 
                    "<button class='btn btn-danger btn-sm btn-delete deleteButton' data-toggle='confirmation' data-singleton='true' value='".$item->id."'><i class='fa fa-trash-o'></i></button>";
                    
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

        $this->validate($request, [
            'matchentry_id' => 'required',
            'athlete_id' => 'required',            
            ]);        

       	$matchgroup = MatchGroup::create($request->all());
        
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

        $matchgroup = MatchEntry::find($id)->update($request->all());

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
        $matchgroup = MatchGroup::destroy($id);

        return response()->json($id);
    }
}
