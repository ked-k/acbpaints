<?php

namespace App\Http\Controllers\inventory;
use App\Models\inventory\uom;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = uom::orderBy('id', 'desc')->get();
        return view('inventory.uom')->with('values', $values);
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
            'uom_name'=>'required']);
            $value = new uom;
            $value->uom_name = $request->input('uom_name');
            // $value->user_id = auth()->user()->id;
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
            'uom_name'=>'required',
            'isActive'=>'required'
        ]);
            $value = uom::find($id);
            $value->uom_name = $request->input('uom_name');
            $value->is_active = $request->input('isActive');
            // $value->user_id = auth()->user()->id;
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
        $value =  uom::find($id);
        $value->delete();
        return redirect()->back()->with('success', 'Record deleted successfully !!');
    }
}
