<?php

namespace App\Http\Controllers\inventory;
use App\Models\inventory\Sale;
use App\Models\User;
use App\Models\inventory\uom;
use App\Models\inventory\MachineItem;
use App\Models\inventory\unit;
use App\Models\inventory\subUnit;
use App\Models\inventory\item;
use App\Models\inventory\customer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tdate = date('Y-m-d');
        $itemcount = MachineItem::where('location_id',session('branchid'))->count();
        $itemsum = MachineItem::where('location_id',session('branchid'))->sum('sale_value');
        $itemTsales = Sale::where('location_id',session('branchid'))->where('payment_type','Msale')->sum('total_amount');
        $itemTDsales = Sale::where('location_id',session('branchid'))->where('payment_type','Msale')
        ->where('date_added', $tdate)->sum('total_amount');
        $values= MachineItem::leftJoin('items', 'machine_items.item_id', '=', 'items.id')
        ->leftJoin('units', 'items.unit_id', '=', 'units.id')
        ->leftJoin('subunits', 'items.subunit_id', '=', 'subunits.id')
        ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
        ->select('*','items.id as mitem_id','machine_items.id as mid')
        ->where('items.location_id', session('branchid'))
        ->get();
        $items= item::leftJoin('units', 'items.unit_id', '=', 'units.id')
        ->leftJoin('subunits', 'items.subunit_id', '=', 'subunits.id')
        ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
        ->select('*','items.id as item_id')
        ->where('items.location_id', session('branchid'))
        ->get();

        return view('inventory.machineStock', compact('values','items','itemcount','itemsum','itemTsales','itemTDsales'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
        $code = $request->route('id'); //getting the request code
        $items= MachineItem::leftJoin('items', 'machine_items.item_id', '=', 'items.id')
        ->leftJoin('units', 'items.unit_id', '=', 'units.id')
        ->leftJoin('subunits', 'items.subunit_id', '=', 'subunits.id')
        ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
        ->select('*','items.id as item_id')
        ->where('machine_items.location_id', session('branchid'))
        ->get(); //getting items in the dropdown
        $customers = customer::where('location_id', session('branchid'))
        ->orderBy('cust_name', 'asc')->get();
        $values= Sale::leftJoin('items', 'sales.item_id', '=', 'items.id')
        ->leftJoin('units', 'items.unit_id', '=', 'units.id')
        ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
        ->select('*','sales.id as saleid','items.id as itemid')
        ->where('sales.sale_code', $id)
        ->where('sales.is_active', 0)
        ->get();// getting all records entered on that stock code
        return view('inventory.newMachineSale', compact('items','code', 'values','customers'));
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
            'unit_id'=>'required',
            'sale_value'=>'required|numeric',
            'item_id'=>'required|numeric',
            'sale_valuem'=>'required'
        ]);

            $itemid = $request->input('item_id');
                $isExist =  MachineItem::select("*")
                ->where('machine_items.item_id', $itemid)
                ->exists();
            if ($isExist) {
                return  redirect()->back()->with('error', 'Item already exists !!');
            }else{
                $qty= 1;

                $value = new MachineItem();
                $value->item_id = $request->input('item_id');
                $value->sale_value = $request->input('sale_value');
                $value->unit_id = $request->input('unit_id');
                $value->location_id = session('branchid');
                $value->user_id = auth()->user()->id;
                $value->save();

                $value = new Sale();
                $value->payment_type = 'MTransfer';
                $value->qty_given = 1;
                $value->sale_price = $request->input('sale_valuem');
                $value->total_amount = $request->input('sale_value');
                $value->date_added = date('Y-m-d');
                $value->item_id = $request->input('item_id');
                $value->location_id = session('branchid');
                $value->sale_code = 'MT'.rand(400,1000).time();
                $value->users_id = auth()->user()->id;
                $value->sale_year = date("Y");
                $value->sale_month = date("M-Y");
                $value->sale_week = date("Y-M-W");
                $value->save();

                item::where('id', $itemid)->update(['qty_left' => DB::raw('qty_left - '.$qty)]);
                return  redirect()->back()->with('success', 'Item Record Successfully added !!');
            }
    }


    public function storemachineSaleItem(Request $request)
    {
        $this->validate($request,[

            'sale_price'=>'required|numeric',
            'item_id'=>'required',
            'sale_code'=>'required'
        ]);
            $code = $request->route('id');
            $scode = $request->input('sale_code');
            $itemid = $request->input('item_id');
            $price = $request->input('sale_price');
                $isExist = Sale::select("*")
                ->where('sales.sale_code', $scode)
                ->where('sales.item_id', $itemid)
                ->exists();
            if ($isExist) {
                sale::where('sales.sale_code', $scode)
                ->where('sales.item_id', $itemid)
                //->increment('qty_given',$request->input('qty_given'))
                ->update([
                    'sale_price' => DB::raw('sale_price + '.$request->input('sale_price')),
                    'total_amount' => DB::raw('total_amount + '.$request->input('sale_price'))
                  ]);
                  MachineItem::where('item_id', $itemid)->update(['sale_value' => DB::raw('sale_value - '.$price)]);
                return  redirect()->back()->with('success', 'Item qty was Successfully updated !!');
            }else{

                $value = new Sale();
                $value->discount = 0;
                $value->qty_given = 1;
                $value->sale_price = $request->input('sale_price');
                $value->total_amount = $request->input('sale_price');
                $value->payment_type = 'Msale';
                $value->date_added = date('Y-m-d');
                $value->item_id = $request->input('item_id');
                $value->location_id = session('branchid');
                $value->sale_code = $request->input('sale_code');
                $value->users_id = auth()->user()->id;
                $value->sale_year = date("Y");
                $value->sale_month = date("M-Y");
                $value->sale_week = date("Y-M-W");
                $value->save();
                MachineItem::where('item_id', $itemid)->update(['sale_value' => DB::raw('sale_value - '.$price)]);
                return  redirect()->back()->with('success', 'Item was Successfully added !!');
            }
    }

    public function getMachineItem(Request $request){

        $itemData['data'] = MachineItem::select('sale_value as salevalue')
        ->where('item_id',$request->item_id)
        ->get();

        return response()->json($itemData);

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
            'item_id'=>'required|numeric',
            'sale_value'=>'required|numeric',
        ]);
        $itemid = $request->input('item_id');
        $price= $request->input('sale_value');
        MachineItem::where('item_id', $itemid)->update(['sale_value' => DB::raw('sale_value + '.$price)]);
            $qty= 1;

            $value = new Sale();
            $value->payment_type = 'MTransfer';
            $value->qty_given = 1;
            $value->sale_price = $request->input('sale_value');
            $value->total_amount = $request->input('sale_value');
            $value->date_added = date('Y-m-d');
            $value->item_id = $request->input('item_id');
            $value->location_id = session('branchid');
            $value->sale_code = 'MT'.rand(400,1000).time();
            $value->users_id = auth()->user()->id;
            $value->sale_year = date("Y");
            $value->sale_month = date("M-Y");
            $value->sale_week = date("Y-M-W");
            $value->save();

            item::where('id', $itemid)->update(['qty_left' => DB::raw('qty_left - '.$qty)]);
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
        //
    }
}
