<?php

namespace App\Http\Controllers\Master;

use App\Athlete;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Filters\AthleteFilters;
use App\Filters\QueryFilters;
use App\Traits\UploadTrait;
use App\Traits\StringTrait;
use Image;
use DB;

class AthleteControllers extends Controller
{
    use UploadTrait;
    use StringTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.athletes');
    }

     /**
     * Data for DataTables
     *
     * @return \Illuminate\Http\Response
     */
    public function masterDataTable(){

        $data = Athlete::where('athletes.deleted_at', null)
                    ->join('countries', 'athletes.country_id', '=', 'countries.id')           
                    ->join('type_sports', 'athletes.typesport_id', '=', 'type_sports.id')
                    ->select('athletes.*', DB::raw('CONCAT(athletes.firstname, " ", athletes.lastname) as fullname'), 'countries.name as country_name', 'countries.code as country_code', 'type_sports.name as typesport_name')->get();

        return $this->makeTable($data);
    }

    // Data for DataTables with Filters
    public function getDataWithFilters(AthleteFilters $filters){        
        
        /* Note : kalo nanti butuh fungsi ->get() , tinggal ->get() di variable nya aja, 
         * e.g : $data->get();
         */
        // dd($filters);

        $data = Athlete::filter($filters)->with('country')->get();

        return $data;
    }

    // Datatable template
    public function makeTable($data){

        return Datatables::of($data)
                ->editColumn('height', function ($item) {
                    return $item->height." cm";                    
                })
                ->editColumn('weight', function ($item) {
                    return $item->weight." kg";                    
                })
                ->editColumn('country_name', function ($item) {

                    return "(".$item->country_code.") ".$item->country_name;
                    
                })
                ->editColumn('photo', function ($item) {    
                                   
                    try{
                        Image::make($item->photo);
                        $popupImage = $item->photo;
                        $errors = 0;
                    } 
                    catch(\Exception $e){
                        $popupImage = asset('image/missing.png');
                        $errors = 1;
                    }                    

                    // Using escape string &#39; => '
                    return "<img onclick='popupImage(&#39;".$popupImage."&#39;, &#39;".$errors."&#39;)' class='myImg' width='50px;' height='50px;' src='".$item->photo."' onError='this.onerror=null;this.src=&#39;".asset('image/missing.png')."&#39;;'>";
                    
                })
                ->editColumn('country_name', function ($item) {

                    return "(".$item->country_code.") ".$item->country_name;
                    
                })
                ->addColumn('action', function ($item) {

                    return 
                    "<a href='".url('athletes/edit/'.$item->id)."' class='btn btn-sm btn-warning'><i class='fa fa-pencil'></i></a>
                    <button class='btn btn-danger btn-sm btn-delete deleteButton' data-toggle='confirmation' data-singleton='true' value='".$item->id."'><i class='fa fa-trash-o'></i></button>";
                    
                })
                ->rawColumns(['photo', 'action'])
                ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.form.athlete-form');
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
            'firstname' => 'required',
            'gender_type' => 'required',
            'height' => 'numeric|min:2',
            'weight' => 'numeric|min:2',
            'country_id' => 'required',
            'typesport_id' => 'required',
            'photo_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

        // Upload file process
        ($request->photo_file != null) ? 
            $photo_url = $this->imageUpload($request->photo_file, "athletes/".$this->getRandomPath()) : $photo_url = "";        

        if($request->photo_file != null) $request['photo'] = $photo_url;

        $athlete = Athlete::create($request->all());
        
        return response()->json(['responseText' => 'Success!', 'url' => url('/athletes')]);
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
        $data = Athlete::where('id', $id)->first();

        return view('master.form.athlete-form', compact('data'));
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
            'firstname' => 'required',
            'gender_type' => 'required',
            'height' => 'numeric|min:2',
            'weight' => 'numeric|min:2',
            'country_id' => 'required',
            'typesport_id' => 'required',
            'photo_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

        // Upload file process
        ($request->photo_file != null) ? 
            $photo_url = $this->imageUpload($request->photo_file, "athletes/".$this->getRandomPath()) : $photo_url = "";        

        if($request->photo_file != null) $request['photo'] = $photo_url;

        $athlete = Athlete::find($id)->update($request->all());

        return response()->json(
            [
                'responseText' => 'Success!', 
                'url' => url('/athletes'),
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
        $athlete = Athlete::destroy($id);

        return response()->json($id);
    }
}
