<?php

namespace App\Http\Controllers\Master;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TypeSport;
use Yajra\Datatables\Facades\Datatables;
use App\Filters\TypeSportFilters;
use App\Traits\StringTrait;
use DB;

class TypeSportController extends Controller
{
    use StringTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.typesport');
    }

    /**
     * Data for DataTables
     *
     * @return \Illuminate\Http\Response
     */
    public function masterDataTable(){

        $data = DB::table('type_sports')
                    ->join('kind_sports', 'type_sports.kindsport_id', '=', 'kind_sports.id')
                    ->where('type_sports.deleted_at', null)
                    ->select('type_sports.*', 'kind_sports.name as kindsport_name')->get();

        return $this->makeTable($data);
    }

    // Data for DataTables with Filters
    public function getDataWithFilters(TypeSportFilters $filters){        
        
        /* Note : kalo nanti butuh fungsi ->get() , tinggal ->get() di variable nya aja, 
         * e.g : $data->get();
         */
        $data = TypeSport::filter($filters)->get();

        return $data;
    }

    // Datatable template
    public function makeTable($data){

        return Datatables::of($data)             
                ->editColumn('description', function ($item) {
                    $description = $this->replaceSingleQuote($item->description);
                    return
                    "<a class='open-description-modal' data-target='#full-width' data-toggle='modal' data-title='".$item->name." description' data-description='".$description."' style='color: black;text-decoration: none;'> ".str_limit($item->description, 50)." </a>";
                })
                ->addColumn('action', function ($item) {

                    return 
                    "<a href='".url('typesport/edit/'.$item->id)."' class='btn btn-sm btn-warning'><i class='fa fa-pencil'></i></a>
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
        return view('master.form.typesport-form');
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
            'kindsport_id' => 'required',
            ]);

       	$typeSport = TypeSport::create($request->all());       	
        
        return response()->json(['responseText' => 'Success!', 'url' => url('/typesport')]);
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
        $data = TypeSport::where('id', $id)->first();

        return view('master.form.typesport-form', compact('data'));
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
            'kindsport_id' => 'required',
            ]);

        $typeSport = TypeSport::find($id)->update($request->all());

        return response()->json(
            [
                'responseText' => 'Success!', 
                'url' => url('/typesport'),
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
        $typeSport = TypeSport::destroy($id);

        return response()->json($id);
    }
}
