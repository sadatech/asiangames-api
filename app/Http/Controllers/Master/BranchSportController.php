<?php

namespace App\Http\Controllers\Master;

use App\BranchSport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\Datatables\Facades\Datatables;
use App\Filters\BranchSportFilters;
use App\Filters\QueryFilters;
use App\Traits\UploadTrait;
use App\Traits\StringTrait;
use Image;
use DB;

class BranchSportController extends Controller
{
    use UploadTrait;
    use StringTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){

    }

    public function index()
    {
        return view('master.branchsport');
    }

    /**
     * Data for DataTables
     *
     * @return \Illuminate\Http\Response
     */
    public function masterDataTable(){

        $data = BranchSport::all();

        return $this->makeTable($data);
    }

    // Data for DataTables with Filters
    public function getDataWithFilters(BranchSportFilters $filters){        
        
        /* Note : kalo nanti butuh fungsi ->get() , tinggal ->get() di variable nya aja, 
         * e.g : $data->get();
         */
        $data = BranchSport::filter($filters)->get();

        return $data;
    }

    // Data for DataTables with Filters
    public function getDataWithFilters2(Request $request){        
        
        /* Note : kalo nanti butuh fungsi ->get() , tinggal ->get() di variable nya aja, 
         * e.g : $data->get();
         */
        // $data = BranchSport::filter($filters)->get();

        return $request->all();
    }

    // Datatable template
    public function makeTable($data){

        return Datatables::of($data)
                ->editColumn('icon', function ($item) {
                    // Using escape string &#39; => '
                    return "<img width='50px;' height='50px;' src='".$item->icon."' onError='this.onerror=null;this.src=&#39;".asset('image/missing.png')."&#39;;'>";
                    
                })
                ->editColumn('description', function ($item) {
                    // return str_limit($item->description, 50);
                    // $description = str_replace("'", "&#39;", $item->description);
                    $description = $this->replaceSingleQuote($item->description);
                    return
                    "<a class='open-description-modal' data-target='#full-width' data-toggle='modal' data-title='".$item->name." description' data-description='".$description."' style='color: black;text-decoration: none;'> ".str_limit($item->description, 50)." </a>";
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
                ->addColumn('action', function ($item) {

                    return 
                    "<a href='".url('branchsport/edit/'.$item->id)."' class='btn btn-sm btn-warning'><i class='fa fa-pencil'></i></a>
                    <button class='btn btn-danger btn-sm btn-delete deleteButton' data-toggle='confirmation' data-singleton='true' value='".$item->id."'><i class='fa fa-trash-o'></i></button>";
                    
                })
                ->rawColumns(['icon', 'photo', 'description', 'action'])
                ->make(true);

    }

    /**
     * Data for select2
     *
     * @return \Illuminate\Http\Response
     */
    public function getDataAll(){
        $data = BranchSport::all();        

        return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('master.form.branchsport-form');
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
            'location' => 'required',
            'icon_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

        // Upload file process
        ($request->icon_file != null) ? 
            $icon_url = $this->imageUpload($request->icon_file, "branchsports/icon") : $icon_url = "";

        ($request->photo_file != null) ? 
            $photo_url = $this->imageUpload($request->photo_file, "branchsports/photo") : $photo_url = "";        
        if($request->icon_file != null) $request['icon'] = $icon_url;
        if($request->photo_file != null) $request['photo'] = $photo_url;    

        $branchSport = BranchSport::create($request->all());
        
        return response()->json(['responseText' => 'Success!', 'url' => url('/branchsport')]);
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
    public function edit(Request $request, $id)
    {
        $data = BranchSport::where('id', $id)->first();

        return view('master.form.branchsport-form', compact('data'));
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
            'location' => 'required',
            'icon_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'photo_file' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ]);

        // Upload file process
        ($request->icon_file != null) ? 
            $icon_url = $this->imageUpload($request->icon_file, "branchsports/icon") : $icon_url = "";

        ($request->photo_file != null) ? 
            $photo_url = $this->imageUpload($request->photo_file, "branchsports/photo") : $photo_url = "";        
        if($request->icon_file != null) $request['icon'] = $icon_url;
        if($request->photo_file != null) $request['photo'] = $photo_url;

        $branchSport = BranchSport::find($id)->update($request->all());

        return response()->json(
            [
                'responseText' => 'Success!', 
                'url' => url('/branchsport'),
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
        $branchSport = BranchSport::destroy($id);

        return response()->json($id);
    }

    public function nearby_competition()
    {
        $inputJSON = file_get_contents('php://input');
        $decode = json_decode($inputJSON, true);
        
        $get_lat = $decode['data'][0]['latitude'];
        $get_long = $decode['data'][0]['longitude'];

        $branch_sport = BranchSport::get();
        foreach ($branch_sport as $branch) {
            $datamaps = file_get_contents("https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=".$get_lat.",".$get_long."&destinations=".$branch['latitude'].",".$branch['longitude']."&key=%20AIzaSyCWpwVwu1hO6TJW1H8x_zlhrLfbSbQ2r3o");
            $decode_maps = json_decode($datamaps,true);
            $distance = $decode_maps['rows'][0]['elements'][0]['distance']['value'];
            // echo $distance."<br>";
            if ($distance < 1500000) {
                $data[] = $branch;
            }else{
                $data[] = "lewat";
            }
            return response()->json($data);
        }
    }
}
