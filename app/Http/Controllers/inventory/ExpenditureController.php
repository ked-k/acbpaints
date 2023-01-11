<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inventory\Expenditure;

class ExpenditureController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $values = Expenditure::leftJoin('users', 'expenditures.user_id', '=', 'users.id')
        ->orderBy('expenditures.id', 'desc')
        ->select('*','expenditures.id as EId')->get();
        return view('inventory.expenditures', compact('values'));
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
        //
        $request->validate([
       'reff_number'=>'required',
       'description'=>'required',
        'exp_amount'=>'required',
       'type'=>'required',
       'date_added'=>'required'
        ]);
          $year = date('Y', strtotime($request->input('date_added')));
        $week = date('Y-M-W', strtotime($request->input('date_added')));
        $month = date('M-Y', strtotime($request->input('date_added')));

        $value = new Expenditure();
        $value->reff_number = $request->input('reff_number');
        $value->description = $request->input('description');
        $value->amount= $request->input('exp_amount');
        $value->type = $request->input('type');
        $value->exp_year = $year;
        $value->exp_month = $month;
        $value->exp_week = $week;
        $value->date_added = $request->input('date_added');
        $value->user_id =  auth()->user()->id;
        $value->save();
        return  redirect()->back()->with('success', 'Expense Successfully added !!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Expenditure  $expenditure
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        $value = Expenditure::find($id);
        $value->delete();
        return redirect()->back()->with('success', 'Record deleted successfully !!');

    }
}
