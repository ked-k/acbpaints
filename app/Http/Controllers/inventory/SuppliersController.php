<?php

namespace App\Http\Controllers\inventory;
use App\Models\inventory\supplier;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SuppliersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = supplier::orderBy('id', 'desc')->get();
        return view('inventory.Supplier')->with('values', $values);
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
            'sup_name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'email'=>'required'
        ]);
            $value = new supplier;
            $value->sup_name = $request->input('sup_name');
            $value->address = $request->input('address');
            $value->contact = $request->input('contact');
            $value->email = $request->input('email');
            $value->description = $request->input('description');
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
            'sup_name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'email'=>'required',
            'isActive'=>'required'
        ]);
            $value = supplier::find($id);
            $value->sup_name = $request->input('sup_name');
            $value->address = $request->input('address');
            $value->contact = $request->input('contact');
            $value->email = $request->input('email');
            $value->description = $request->input('description');
            $value->is_active = $request->input('isActive');
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
        $value = Supplier::find($id);
        $value->delete();
        return redirect()->back()->with('success', 'Record deleted successfully !!');
    }
}
