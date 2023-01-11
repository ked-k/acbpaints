<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\inventory\supplier;
use App\Models\inventory\uom;
use App\Models\inventory\Sale;
use App\Models\inventory\customer;
use App\Models\inventory\ConfirmedSale;
use App\Models\inventory\unit;
use App\Models\inventory\subUnit;
use App\Models\inventory\item;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {   $code = $request->route('id'); //getting the request code
        $items= item::leftJoin('units', 'items.unit_id', '=', 'units.id')
        ->leftJoin('subunits', 'items.subunit_id', '=', 'subunits.id')
        ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
        ->select('*','items.id as item_id')
        ->where('items.location_id', session('branchid'))
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
        return view('inventory.newMainSale', compact('items','code', 'values','customers'));
    }

    public function getitemQty(Request $request){

        $itemData['data'] = item::select('qty_left as qtyleft', 'sale_price as cost')
        			->where('items.id',$request->item_id)
        			->get();

        return response()->json($itemData);

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
            'discount'=>'required',
            'sale_price'=>'required',
            'qty_given'=>'required|numeric',
            'total_amount'=>'required',
            'item_id'=>'required',
            'sale_code'=>'required'
        ]);
            $code = $request->route('id');
            $scode = $request->input('sale_code');
            $itemid = $request->input('item_id');
            $qty = $request->input('qty_given');
                $isExist = sale::select("*")
                ->where('sales.sale_code', $scode)
                ->where('sales.item_id', $itemid)
                ->exists();
            if ($isExist) {
                sale::where('sales.sale_code', $scode)
                ->where('sales.item_id', $itemid)
                //->increment('qty_given',$request->input('qty_given'))
                ->update([
                    'qty_given' => DB::raw('qty_given + '.$request->input('qty_given')),
                    'total_amount' => DB::raw('total_amount + '.$request->input('total_amount')),
                    'discount' => DB::raw('discount + '.$request->input('discount'))
                  ]);
                  Item::where('id', $itemid)->update(['qty_left' => DB::raw('qty_left - '.$qty)]);
                return  redirect()->back()->with('success', 'Item qty was Successfully updated !!');
            }else{

                $value = new sale();
                $value->discount = $request->input('discount');
                $value->qty_given = $request->input('qty_given');
                $value->sale_price = $request->input('sale_price');
                $value->total_amount = $request->input('total_amount');
                $value->date_added = date('Y-m-d');
                $value->item_id = $request->input('item_id');
                $value->location_id = session('branchid');
                $value->sale_code = $request->input('sale_code');
                $value->users_id = auth()->user()->id;
                $value->sale_year = date("Y");
                $value->sale_month = date("M-Y");
                $value->sale_week = date("Y-M-W");
                $value->save();
                Item::where('id', $itemid)->update(['qty_left' => DB::raw('qty_left - '.$qty)]);
                return  redirect()->back()->with('success', 'Item was Successfully added !!');
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $values= Sale::leftJoin('items', 'sales.item_id', '=', 'items.id')
        ->leftJoin('confirmed_sales', 'sales.sale_code', '=', 'confirmed_sales.sale_code')
        ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
        ->leftJoin('customers', 'confirmed_sales.customer_id', '=', 'customers.id')
        ->select('*','sales.id as saleid','items.id as itemid', 'sales.total_amount as itemamt','sales.sale_price as sprice')
        ->where('sales.sale_code', $id)
        ->get();// getting all records entered on that sale code

      $custs= Sale::leftJoin('confirmed_sales', 'sales.sale_code', '=', 'confirmed_sales.sale_code')
        ->leftJoin('customers', 'confirmed_sales.customer_id', '=', 'customers.id')
        ->select('*','confirmed_sales.id as saleNo')
        ->where('sales.sale_code', $id)
        ->limit(1)
        ->get();
        return view('inventory.invoice', compact('values','custs','id'));
    }
    public function print($id)
    {
        $values= Sale::leftJoin('items', 'sales.item_id', '=', 'items.id')
        ->leftJoin('confirmed_sales', 'sales.sale_code', '=', 'confirmed_sales.sale_code')
        ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
        ->leftJoin('customers', 'confirmed_sales.customer_id', '=', 'customers.id')
        ->select('*','sales.id as saleid','items.id as itemid', 'sales.total_amount as itemamt','sales.sale_price as sprice')
        ->where('sales.sale_code', $id)
        ->get();// getting all records entered on that sale code

        $cust= Sale::leftJoin('confirmed_sales', 'sales.sale_code', '=', 'confirmed_sales.sale_code')
        ->leftJoin('customers', 'confirmed_sales.customer_id', '=', 'customers.id')
        ->select('*','confirmed_sales.id as saleNo')
        ->where('sales.sale_code', $id)
        ->limit(1)
        ->first();
        return view('inventory.reciept', compact('values','cust'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function salesHistory()
    {
        $edit='d-none';
        $print='d-none';
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $values=sale::leftJoin('users', 'sales.users_id', '=', 'users.id')
        ->groupBy('sale_code')->select('*', DB::raw('sum(total_amount) as totalamount'))
        ->where('sales.location_id', session('branchid'))
        ->orderby('sales.id', 'desc')
        ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('inventory.MainSaleHistory', compact('values','edit','print'));
    }
    
    public function salesHistoryToday()
    {
        $edit='d-none';
        $print='d-none';
        $day =  date('Y-m-d'); 
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $values=sale::leftJoin('users', 'sales.users_id', '=', 'users.id')
        ->groupBy('sale_code')->select('*', DB::raw('sum(total_amount) as totalamount'))
        ->where('sales.location_id', session('branchid'))
        ->where('date_added',$day)
        ->where('payment_type', '!=' , 'MTransfer')
        ->where('payment_type', '!=' , 'TableTransfer')
        ->orderby('sales.id', 'desc')
        ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('inventory.MainSaleHistory', compact('values','edit','print'));
    }
    public function salesHistoryYesturday()
    {
        $day =  date('Y-m-d',strtotime("-1 days"));        
        $edit='d-none';
        $print='d-none';
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $values=sale::leftJoin('users', 'sales.users_id', '=', 'users.id')
        ->groupBy('sale_code')->select('*', DB::raw('sum(total_amount) as totalamount'))
        ->where('sales.location_id', session('branchid'))
        ->where('date_added',$day)
        ->where('payment_type', '!=' , 'MTransfer')
        ->where('payment_type', '!=' , 'TableTransfer')
        ->orderby('sales.id', 'desc')
        ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('inventory.MainSaleHistory', compact('values','edit','print'));
    }

    public function salesHistoryconfirmed()
    {
        $edit='d-none';
        $print='';
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $values=sale::leftJoin('users', 'sales.users_id', '=', 'users.id')
        ->groupBy('sale_code')->select('*', DB::raw('sum(total_amount) as totalamount'))
        ->where('sales.location_id', session('branchid'))
        ->where('sales.is_active',0)
        ->orderby('sales.id', 'desc')
        ->where('payment_type', '!=' , 'MTransfer')
        ->where('payment_type', '!=' , 'TableTransfer')
        ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('inventory.MainSaleHistory', compact('values','edit','print'));
    }
      public function TransferHistory()
    {
        $edit='d-none';
        $print='';
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $values=sale::leftJoin('users', 'sales.users_id', '=', 'users.id')
        ->groupBy('sale_code')->select('*', DB::raw('sum(total_amount) as totalamount'))
        ->where('sales.location_id', session('branchid'))
        //->where('sales.is_active',0)
        ->orderby('sales.id', 'desc')
        ->where('payment_type', '=' , 'MTransfer')
        ->Orwhere('payment_type', '=' , 'TableTransfer')
        ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('inventory.MainSaleHistory', compact('values','edit','print'));
    }

    public function salesHistoryUnconfirmed()
    {
        $edit='';
        $print='d-none';
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $values=sale::leftJoin('users', 'sales.users_id', '=', 'users.id')
        ->groupBy('sale_code')->select('*', DB::raw('sum(total_amount) as totalamount'))
        ->where('sales.location_id', session('branchid'))
        ->where('sales.is_active',1)
        ->orderby('sales.id', 'desc')
        ->get();
        DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
        return view('inventory.MainSaleHistory', compact('values','edit','print'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
         try{
            $this->validate($request,[
                'amtpaid'=>'required|numeric',
                'salekcode'=>'required|string',
                'saletotalamt'=>'required|numeric',
                'payment'=>'required|string',
            ]);

            $value = new ConfirmedSale();
                $value->total_amount = $request->input('saletotalamt');
                $value->payment_type = $request->input('payment');
                $value->paid_amount = $request->input('amtpaid');
                $value->balance = $request->input('balance');
                $value->customer_id = $request->input('customer');
                $value->location_id = session('branchid');
                $value->sale_code = $request->input('salekcode');
                $value->user_id = auth()->user()->id;
                $value->sale_year = date("Y");
                $value->sale_month = date("M-Y");
                $value->sale_week = date("Y-M-W");
                $value->save();
                 Sale::where('sale_code', $request->input('salekcode'))->where('is_active', 0) ->update(['is_active' => 1,'item_state'=> 'closed']);
                 if($request->input('payment')=="Credit"){
                    $diffAmt=  $request->input('balance');
                    customer::where('id', $request->input('customer'))->update(['balance' => DB::raw('balance + '.$diffAmt)]);
                 }

               return redirect('inventory/sale/new/MSL'.mt_rand(1000, 9999).time())->with('success', 'The sale was recorded successfully !!');


        }catch(\Exception $error){

            return redirect()->back()->with('error', 'Something occared and the transaction was not saved, please try again');
        }
        }

        public function updatePrint(Request $request)
        {
             try{
                $this->validate($request,[
                    'amtpaid'=>'required|numeric',
                    'salekcode'=>'required|string',
                    'saletotalamt'=>'required|numeric'
                ]);

                $value = new ConfirmedSale();
                    $value->total_amount = $request->input('saletotalamt');
                    $value->paid_amount = $request->input('amtpaid');
                    $value->balance = $request->input('balance');
                    $value->customer_id = $request->input('customer');
                    $value->location_id = session('branchid');
                    $value->sale_code = $request->input('salekcode');
                    $value->user_id = auth()->user()->id;
                    $value->sale_year = date("Y");
                    $value->sale_month = date("M-Y");
                    $value->sale_week = date("Y-M-W");
                    $value->save();
                Sale::where('sale_code', $request->input('salekcode'))->where('is_active', 0) ->update(['is_active' => 1,'item_state'=> 'closed']);


                   return redirect('inventory/sales/print/'.$request->input('salekcode'))->with('success', 'The sale was recorded successfully !!');


            }catch(\Exception $error){

                return redirect()->back()->with('error', 'Something occared');
            }
            }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyItem(Request $request)
    {
    //    $id = $request->id;
    //    $qty = $request->qty;
    //    $item= $request->item;
    $this->validate($request,[
        'saleid'=>'required|numeric',
        'itemid'=>'required|numeric',
        'qty_given'=>'required|numeric'
    ]);
    $sid =  $request->input('saleid');
    $qty =  $request->input('qty_given');
    $item =  $request->input('itemid');
      try {
      Sale::where('id', $sid)->where('is_active', 0)->delete();
      item::where('id', $item) ->update(['qty_left' => DB::raw('qty_left + '.$qty)]);
      return redirect()->back()->with('success', 'Item was deleted successfully !!');
      }
      catch(\Exception $error){
        return redirect()->back()->with('error', 'Record can not be deleted !!');
      }
    }
}
