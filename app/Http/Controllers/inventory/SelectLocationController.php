<?php

namespace App\Http\Controllers\inventory;
use App\Models\inventory\location;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SelectLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session()->has('branch')) {
            session()->forget('branch');
            }

        $locations = location::orderBy('location_name', 'asc')->get();
        return view('inventory.selectLocation',compact('locations'));
    }
    public function index2()
    {
        $locations = location::orderBy('location_name', 'asc')->get();
        return view('inventory.locations',compact('locations'));
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
        $this->validate($request,[
            'name'=>'required',
            'region'=>'required'
        ]);
            $value = new location;
            $value->location_name = $request->input('name');
            $value->region_name = $request->input('region');
            $value->users_id = auth()->user()->id;
            $value->save();
            return redirect()->back()->with('success', 'Record Successfully added !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        session(['branch' => $id]);
        $branch = location::where('id', $id)->get();
        session(['branchdata' => $branch]);
        //return session('branchdata');
        foreach(Session('branchdata') as $data){
         $cur = $data->location_name;
         session(['branchname' => $cur]);
         session(['branchid' => $data->id]);
        }
        session(['bizcontact'=>'+256-704083209']);
        session(['bizname'=>'Ripon Technologies Ug Ltd']);
        session(['appNam'=>'info@ripontechug.com']);
        session(['bizlocation'=>'Makerere Kampala']);
        session(['appNam' => 'Rpos']);
        return redirect('inventory/dashboard')->with('success', 'Welcome '.auth()->user()->name.', you are now working with '.$cur.' Branch');
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
        $this->validate($request,[
            'name'=>'required',
            'region'=>'required',
        ]);
            $value = location::find($id);
            $value->location_name = $request->input('name');
            $value->region_name = $request->input('region');
           // $value->is_active = $request->input('isActive');
            $value->update();
            return redirect()->back()->with('success', 'Record Successfully Updated !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $value =  location::find($id);
        $value->delete();
        return redirect()->back()->with('success', 'Record deleted successfully !!');
    }
}
