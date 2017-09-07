<?php

namespace App\Http\Controllers\Master;

use App\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Filters\CountryFilters;
use App\Traits\StringTrait;
use App\Traits\UploadTrait;
use Image;
use DB;

class CountriesController extends Controller
{
    use StringTrait;
    use UploadTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('master.countries');
    }

    /**
     * Data for DataTables
     *
     * @return \Illuminate\Http\Response
     */
    public function masterDataTable(){

        $data = Country::all();

        return $this->makeTable($data);
    }

    // Data for DataTables with Filters
    public function getDataWithFilters(CountryFilters $filters){        
        
        /* Note : kalo nanti butuh fungsi ->get() , tinggal ->get() di variable nya aja, 
         * e.g : $data->get();
         */
        $data = Country::filter($filters)->get();

        return $data;
    }

    // Datatable template
    public function makeTable($data){

        return Datatables::of($data)
                ->editColumn('description', function ($item) {
                    // return str_limit($item->description, 50);
                    // $description = str_replace("'", "&#39;", $item->description);
                    $description = $this->replaceSingleQuote($item->description);
                    return
                    "<a class='open-description-modal' data-target='#full-width' data-toggle='modal' data-title='".$item->name." description' data-description='".$description."' style='color: black;text-decoration: none;'> ".str_limit($item->description, 50)." </a>";
                })
                ->editColumn('flag', function ($item) {

                    try{
                        Image::make($item->flag);
                        $popupImage = $item->flag;
                        $errors = 0;
                    } 
                    catch(\Exception $e){
                        $popupImage = asset('image/missing.png');
                        $errors = 1;
                    }

                    // Using escape string &#39; => '
                    return "<img onclick='popupImage(&#39;".$popupImage."&#39;, &#39;".$errors."&#39;)' class='myImg' width='50px;' height='50px;' src='".$item->flag."' onError='this.onerror=null;this.src=&#39;".asset('image/missing.png')."&#39;;'>";
                    
                })
                ->addColumn('action', function ($item) {

                    return 
                    "<a href='".url('countries/edit/'.$item->id)."' class='btn btn-sm btn-warning'><i class='fa fa-pencil'></i></a>
                    <button class='btn btn-danger btn-sm btn-delete deleteButton' data-toggle='confirmation' data-singleton='true' value='".$item->id."'><i class='fa fa-trash-o'></i></button>";
                    
                })
                ->rawColumns(['flag', 'description', 'action'])
                ->make(true);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.form.country-form');
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
            'code' => 'required',
            'name' => 'required',
            'flag_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',            
            ]);

        // Upload file process
        ($request->flag_file != null) ? 
            $flag_url = $this->imageUpload($request->flag_file, "country/".$this->getRandomPath()) : $flag_url = "";
     
        if($request->flag_file != null) $request['flag'] = $flag_url;  

        $country = Country::create($request->all());
        
        return response()->json(['responseText' => 'Success!', 'url' => url('/countries')]);
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
        $data = Country::where('id', $id)->first();

        return view('master.form.country-form', compact('data'));
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
            'name' => 'required',
            'flag_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',  
            ]);

        // Upload file process
        ($request->flag_file != null) ? 
            $flag_url = $this->imageUpload($request->flag_file, "country/".$request->name) : $flag_url = "";
     
        if($request->flag_file != null) $request['flag'] = $flag_url;  

        $country = Country::find($id)->update($request->all());

        return response()->json(
            [
                'responseText' => 'Success!', 
                'url' => url('/countries'),
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
        $country = Country::destroy($id);

        return response()->json($id);
    }
}
