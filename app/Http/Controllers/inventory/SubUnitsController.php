<?php

namespace App\Http\Controllers\inventory;
use App\Models\inventory\subunit;
use App\Models\inventory\unit;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubUnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $valueUnites = unit::orderBy('id', 'desc')->get();
        $values = DB::table('subunits')
        ->join('units', function ($join) {
        $join->on('subunits.unit_id', '=', 'units.id'); })
        ->select('*','subunits.id as SubUnitId', 'subunits.is_active AS SuActive')
        ->get();
        return view('inventory.SubUnits', compact('valueUnites','values'));
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
            'unit_name'=>'required',
            'subunit_name'=>'required'
        ]);
            $value = new subunit();
            $value->unit_id = $request->input('unit_name');
            $value->subunit_name = $request->input('subunit_name');
            $value->user_id = auth()->user()->id;
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
        $this->validate($request,[
            'unit_name'=>'required',
            'subunit_name'=>'required',
            'isActive'=>'required'
        ]);
            $value =subunit::find($id);
            $value->unit_id = $request->input('unit_name');
            $value->subunit_name = $request->input('subunit_name');
            $value->is_active = $request->input('isActive');
            // $value->user_id = auth()->user()->id;
            $value->update();
            return redirect()->back()->with('success', 'Record Successfully updated !!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $value =subunit::find($id);
        $value->delete();
        return redirect()->back()->with('success', 'Record deleted successfully !!');
    }
}
