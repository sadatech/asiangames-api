<?php

namespace App\Http\Controllers\Master;

use App\KindSport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Filters\KindSportFilters;
use DB;

class KindSportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.kindsport');
    }

    /**
     * Data for DataTables
     *
     * @return \Illuminate\Http\Response
     */
    public function masterDataTable(){

        $data = DB::table('kind_sports')
                    ->join('branch_sports', 'kind_sports.branchsport_id', '=', 'branch_sports.id')
                    ->select('kind_sports.*', 'branch_sports.name as branchsport_name')->get();

                    // dd($data2);

        return $this->makeTable($data);
    }

    // Data for DataTables with Filters
    public function getDataWithFilters(KindSportFilters $filters){        
        
        /* Note : kalo nanti butuh fungsi ->get() , tinggal ->get() di variable nya aja, 
         * e.g : $data->get();
         */
        $data = KindSport::filter($filters)->get();

        return $data;
    }

    // Datatable template
    public function makeTable($data){

        return Datatables::of($data)
                ->editColumn('description', function ($item) {
                    return str_limit($item->description, 50);                    
                })
                ->addColumn('action', function ($item) {

                    return 
                    "<a href='".url('kindsport/edit/'.$item->id)."' class='btn btn-sm btn-warning'><i class='fa fa-pencil'></i></a>
                    <button class='btn btn-danger btn-sm btn-delete deleteButton' data-toggle='confirmation' data-singleton='true' value='".$item->id."'><i class='fa fa-trash-o'></i></button>";
                    
                })
                ->rawColumns(['action'])
                ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.form.kindsport-form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	// return $request->all();

        $this->validate($request, [
            'name' => 'required',
            'branchsport_id' => 'required',
            ]);

       	$kindSport = KindSport::create($request->all());
        
        return response()->json(['responseText' => 'Success!', 'url' => url('/kindsport')]);
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
        $data = KindSport::where('id', $id)->first();

        return view('master.form.kindsport-form', compact('data'));
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
            'name' => 'required',
            'branchsport_id' => 'required',
            ]);

        $kindSport = KindSport::find($id)->update($request->all());

        return response()->json(
            [
                'responseText' => 'Success!', 
                'url' => url('/kindsport'),
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
        $kindSport = KindSport::destroy($id);

        return response()->json($id);
    }
}
