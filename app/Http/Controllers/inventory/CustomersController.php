<?php

namespace App\Http\Controllers\inventory;
use App\Models\inventory\customer;
use App\Models\inventory\Transaction;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values = customer::orderBy('id', 'desc')->get();
        return view('inventory.Customers')->with('values', $values);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function receive()
    {
        $customers = customer::orderBy('cust_name', 'asc')->get();
        return view('inventory.newDeposit', compact('customers'));
    }
    public function give()
    {
        $customers = customer::orderBy('cust_name', 'asc')->get();
        return view('inventory.newWithdraw', compact('customers'));
    }

    public function getcust(Request $request){

        $itemData['data'] = customer::where('id',$request->sup_id)->select('balance', 'cust_name')->get();

        return response()->json($itemData);

    }

    public function deposit(Request $request)
    {
        if($request->input('total_amount')>0){
        $request->validate([
            'reff_number'=>'required',
            'customer_id'=>'required',
             'ex_amount'=>'required',           
            'total_amount'=>'required',
            'date_added'=>'required',
        ]);
        $value = new Transaction();
        $value->reff_number = $request->input('reff_number');
        $value->customer_id = $request->input('customer_id');
        $value->total_amount = $request->input('ex_amount');
        $value->dp_amount = $request->input('total_amount');
        $value->type = 'Deposit';
        $value->trans_year = date("Y");
        $value->trans_month = date("M-Y");
        $value->trans_week = date("Y-M-W");
        $value->date_added = $request->input('date_added');
        $value->user_id =  auth()->user()->id;
        $value->save();
        $diffAmt = $request->input('total_amount');      
        $custname  = $request->input('custname');
        customer::where('id', $request->input('customer_id'))->update(['balance' => DB::raw('balance + '.$diffAmt)]);
        return  redirect('inventory/customer/transactions')->with('success', 'Customer '.$custname.' Deposit was Successfully received !!');
    }
    else{
        return  redirect()->back()->with('error', 'Amount paid must be greater than 0 !!');
    }
    }

    public function withdraw(Request $request)
    {
        if($request->input('total_amount')>0){
        $request->validate([
            'reff_number'=>'required',
            'customer_id'=>'required',
             'ex_amount'=>'required',           
            'total_amount'=>'required',
            'date_added'=>'required',
        ]);
        $value = new Transaction();
        $value->reff_number = $request->input('reff_number');
        $value->customer_id = $request->input('customer_id');
        $value->total_amount = $request->input('ex_amount');
        $value->dp_amount = $request->input('total_amount');
        $value->type = 'Withdraw';
        $value->trans_year = date("Y");
        $value->trans_month = date("M-Y");
        $value->trans_week = date("Y-M-W");
        $value->date_added = $request->input('date_added');
        $value->user_id =  auth()->user()->id;
        $value->save();
        $diffAmt = $request->input('total_amount');      
        $custname  = $request->input('custname');
        customer::where('id', $request->input('customer_id'))->update(['balance' => DB::raw('balance - '.$diffAmt)]);
        return  redirect('inventory/customer/transactions')->with('success', 'Customer '.$custname.' Withdraw was Successfully received !!');
    }
    else{
        return  redirect()->back()->with('error', 'Amount paid must be greater than 0 !!');
    }
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
            'cust_name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'email'=>'required'
        ]);
            $value = new customer;
            $value->cust_name = $request->input('cust_name');
            $value->address = $request->input('address');
            $value->contact = $request->input('contact');
            $value->email = $request->input('email');
            $value->location_id = session('branchid');
            $value->user_id = auth()->user()->id;
            $value->save();
            return redirect()->back()->with('success', 'Record Successfully added !!');
        }

        public function transactions()
        {
            $edit='d-none';
            $print='d-none';
            $values=Transaction::leftJoin('users', 'transactions.user_id', '=', 'users.id')
            ->leftJoin('customers', 'transactions.customer_id', '=', 'customers.id')           
            ->where('transactions.type', 'Deposit')
            ->orWhere('transactions.type', 'Withdraw')
            ->orderby('transactions.id', 'desc')
            ->get();
            return view('inventory.CustTransactionHistory', compact('values','edit','print'));
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
            'cust_name'=>'required',
            'address'=>'required',
            'contact'=>'required',
            'email'=>'required',
            'isActive'=>'required'
        ]);
            $value = customer::find($id);
            $value->cust_name = $request->input('cust_name');
            $value->address = $request->input('address');
            $value->contact = $request->input('contact');
            $value->email = $request->input('email');
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
        $value = customer::find($id);
        $value->delete();
        return redirect()->back()->with('success', 'Record deleted successfully !!');
    }
}
