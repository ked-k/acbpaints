<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inventory\supplier;
use App\Models\inventory\uom;
use App\Models\inventory\Stock;
use App\Models\inventory\unit;
use App\Models\inventory\subUnit;
use App\Models\inventory\item;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $values= item::leftJoin('units', 'items.unit_id', '=', 'units.id')
        ->leftJoin('subunits', 'items.subunit_id', '=', 'subunits.id')
        ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
        ->select('*','items.id as item_id')
        ->where('items.location_id', session('branchid'))
        ->get();
        return view('inventory.mainStock', compact('values'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {   $code = $request->route('id'); //getting the request code
        $suppliers = supplier::orderBy('sup_name', 'asc')->get(); //getting all suppliers
        $items= item::leftJoin('units', 'items.unit_id', '=', 'units.id')
        ->leftJoin('subunits', 'items.subunit_id', '=', 'subunits.id')
        ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
        ->select('*','items.id as item_id')
        ->where('items.location_id', session('branchid'))
        ->get(); //getting items in the dropdown

        $values= Stock::leftJoin('items', 'stocks.item_id', '=', 'items.id')
        ->leftJoin('units', 'items.unit_id', '=', 'units.id')
        ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
        ->leftJoin('suppliers', 'items.supplier_id', '=', 'suppliers.id')
        ->select('*','stocks.id as stock_id','items.id as itemid')
        ->where('stocks.stock_code', $id)
        ->where('stocks.is_active', 0)
        ->get();// getting all records entered on that stock code
        return view('inventory.getMainStock', compact('items','suppliers','code', 'values'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function getitemData(Request $request){

        $itemData['data'] = item::leftJoin('units', 'items.unit_id', '=', 'units.id')
        ->leftJoin('suppliers', 'items.supplier_id', '=', 'suppliers.id')
        ->select('units.id as dptid','units.unit_name as dptname','suppliers.id as supid','suppliers.sup_name as suppliername','items.cost_price as cost','qty_left as qtyleft','qty_held as qtyheld','items.sale_price as salep')
        ->where('items.id',$request->item_id)
        ->get();

        return response()->json($itemData);

    }
    public function store(Request $request)
    {
        $this->validate($request,[
            'unit_id'=>'required',
            'supplier_id'=>'required',
            'stock_qty'=>'required|numeric',
            'unit_cost'=>'required',
            'item_id'=>'required',
            'stock_code'=>'required'


        ]);
            $code = $request->route('id');
            $total_cost =$request->input('unit_cost')*$request->input('stock_qty');
            $scode = $request->input('stock_code');
            $itemid = $request->input('item_id');
                $isExist =  Stock::select("*")
                ->where('stocks.stock_code', $scode)
                ->where('stocks.item_id', $itemid)
                ->exists();
            if ($isExist) {
                Stock::where('stocks.stock_code', $scode)
                ->where('stocks.item_id', $itemid)
                //->increment('stock_qty',$request->input('stock_qty'))
                ->update([
                    'stock_qty' => DB::raw('stock_qty + '.$request->input('stock_qty')),
                    'total_cost' => DB::raw('total_cost + '.$total_cost)
                  ]);
                return  redirect()->back()->with('success', 'Record Successfully updated !!');
            }else{

                $value = new Stock();
                $value->unit_id = $request->input('unit_id');
                $value->supplier_id = $request->input('supplier_id');
                $value->stock_qty = $request->input('stock_qty');
                $value->batch_no = $request->input('batch_no');
                $value->unit_cost = $request->input('unit_cost');
                $value->total_cost = $total_cost;
                $value->date_added = date('Y-m-d');
                $value->expiry_date = $request->input('expiry_date');
                $value->item_id = $request->input('item_id');
                $value->location_id = session('branchid');
                $value->stock_code = $request->input('stock_code');
                $value->user_id = auth()->user()->id;
                $value->stock_year = date("Y");
                $value->stock_month = date("M-Y");
                $value->stock_week = date("Y-M-W");
                $value->save();
                return  redirect()->back()->with('success', 'Record Successfully added !!');
            }
    }

    public function saveStock(Request $request){
        $this->validate($request,[
            'item'=>'required',
            'quantity'=>'required',
            'stockcode'=>'required'

        ]);
        $stockcode = $request->input('stockcode');
        Stock::where('stocks.stock_code', $stockcode)->update(['is_active'=> '1']);
        foreach($request->input('item') as $key => $value){
        $item = $value;
            $qty = $request->input('quantity')[$key];
            item::where('items.id', $item)
            ->increment('qty_left',$qty);
        }

        return  redirect('inventory/stockLevels')->with('success', 'Record Successfully added !!');
    }

    public function allmaindoc()
    {


        $options = array('edit'=>'display:none','delete'=>'display:none','view'=>'');
        $delete='display:none';
        $edit='display:none';
        $view='';
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $values=Stock::leftJoin('users', 'stocks.user_id', '=', 'users.id')
        ->groupBy('stock_code')->select('*', DB::raw('count(stock_code) as totalitems'))
        //->where('stocks.is_active', 1)
        ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        // $values=  DB::table('inv_stocklevels')->select('stock_code', DB::raw( 'sum(total_cost) as totalAmt'),DB::raw( 'max(date_added) as date'))
        // ->groupBy('stock_code')
        // ->get();

        return view('inventory.docMainStock', compact('values','delete','edit','view'));
    }
    public function confirmed()
    {


        $options = array('edit'=>'display:none','delete'=>'display:none','view'=>'');
        $delete='display:none';
        $edit='display:none';
        $view='';
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $values=Stock::leftJoin('users', 'stocks.user_id', '=', 'users.id')
        ->groupBy('stock_code')->select('*', DB::raw('count(stock_code) as totalitems'))
        ->where('stocks.is_active', 1)
        ->where('location_id', session('branchid'))
        ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        // $values=  DB::table('inv_stocklevels')->select('stock_code', DB::raw( 'sum(total_cost) as totalAmt'),DB::raw( 'max(date_added) as date'))
        // ->groupBy('stock_code')
        // ->get();

        return view('inventory.docMainStock', compact('values','delete','edit','view'));
    }

    public function unconfirmed()
    {


        $options = array('edit'=>'display:none','delete'=>'display:none','view'=>'');
        $delete='display:none';
        $edit='display:none';
        $view='';
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $values=Stock::leftJoin('users', 'stocks.user_id', '=', 'users.id')
        ->groupBy('stock_code')->select('*', DB::raw('count(stock_code) as totalitems'))
        ->where('stocks.is_active', 0)
        ->where('location_id', session('branchid'))
        ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        // $values=  DB::table('inv_stocklevels')->select('stock_code', DB::raw( 'sum(total_cost) as totalAmt'),DB::raw( 'max(date_added) as date'))
        // ->groupBy('stock_code')
        // ->get();

        return view('inventory.docMainStock', compact('values','delete','edit','view'));
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $value =Stock::find($id);
        $value->delete();
        return redirect()->back()->with('success', 'Record deleted successfully !!');
    }
    public function destroystock($id)
    {
        $value = Stock::where('stock_code', $id)
        //->firstorfail()
        ->delete();
        return redirect()->back()->with('success', 'Records deleted successfully !!');
    }
}
