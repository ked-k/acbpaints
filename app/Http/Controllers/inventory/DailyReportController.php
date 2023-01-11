<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\inventory\supplier;
use App\Models\inventory\uom;
use App\Models\inventory\unit;
use App\Models\User;
use App\Models\inventory\Stock;
use App\Models\inventory\item;
use App\Models\inventory\Sale;

class DailyReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function dailysales(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $this->validate($request,[
            'items_id'=>'required',
            'saleType'=>'required'
        ]);

          $item = $request->input('items_id');
        $to = $request->input('to');
        $from = $request->input('from');
        $sale = $request->input('saleType');
          if ( $item == 0 and $sale == 0)
          {
            $values= Sale::leftJoin('items', 'sales.item_id', '=', 'items.id')
            ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
            ->select('*','sales.date_added as date', DB::raw('sum(total_amount) as totalAmt'),DB::raw('sum(qty_given) as qty'))
            ->where('sales.location_id', session('branchid'))
            ->where('sales.payment_type', '!=' , 'MTransfer')
            ->where('sales.payment_type', '!=' , 'TableTransfer')
            ->whereBetween('sales.date_added', [$from, $to])
            ->groupBy('sales.date_added')
            //->groupBy('sales.item_id')
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale ="All";
            $disp="";
            $userDis="";
            return view('inventory.reportDaily', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item == 0 and $sale != 0)
          {
            $values= Sale::leftJoin('items', 'sales.item_id', '=', 'items.id')
            ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
            ->select('*','sales.date_added as date', DB::raw('sum(total_amount) as totalAmt'),DB::raw('sum(qty_given) as qty'))
            ->where('sales.location_id', session('branchid'))
            ->where('sales.payment_type' , $sale)
            ->whereBetween('sales.date_added', [$from, $to])
            ->groupBy('sales.date_added')
            //->groupBy('sales.item_id')
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale =$sale;
            $disp="";
            $userDis="";
            return view('inventory.reportDaily', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item != 0 and $sale == 0)
          {
            $values= Sale::leftJoin('items', 'sales.item_id', '=', 'items.id')
            ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
            ->select('*','sales.date_added as date', DB::raw('sum(total_amount) as totalAmt'),DB::raw('sum(qty_given) as qty'))
            ->where('sales.location_id', session('branchid'))
            ->where('sales.item_id' , $item)
            ->whereBetween('sales.date_added', [$from, $to])
            ->groupBy('sales.date_added')
            //->groupBy('sales.item_id')
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale =$sale;
            $disp="";
            $userDis="";
            return view('inventory.reportDaily', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif( $item != 0 and $sale != 0)
          {
            $values= Sale::leftJoin('items', 'sales.item_id', '=', 'items.id')
            ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
            ->select('*','sales.date_added as date', DB::raw('sum(total_amount) as totalAmt'),DB::raw('sum(qty_given) as qty'))
            ->where('sales.location_id', session('branchid'))
            ->where('sales.item_id' , $item)
            ->where('sales.payment_type' , $sale)
            ->whereBetween('sales.date_added', [$from, $to])
            ->groupBy('sales.date_added')
            //->groupBy('sales.item_id')
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale =$sale;
            $disp="";
            $userDis="";
            return view('inventory.reportDaily', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
    }
    public function profitmargin(Request $request)
    {

        $item = $request->input('items_id');
        $to = $request->input('to');
        $from = $request->input('from');
          if ( $item != 0 )
          {
            $values= Sale::leftJoin('items', 'sales.item_id', '=', 'items.id')
            ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
            ->select('*','sales.date_added as date', 'sales.sale_price as price',DB::raw('sum(qty_given) as qty'))
            ->where('sales.location_id', session('branchid'))
            ->where('sales.payment_type', '!=' , 'Msale')
            ->where('sales.payment_type', '!=' , 'Tsale')
            ->whereBetween('sales.date_added', [$from, $to])
           // ->where('sales.payment_type' , 'cash')
            ->where('sales.item_id' , $item)
           //->groupBy('sales.date_added')
            ->groupBy('sales.item_id')
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale ="All";
            $disp="";
            $userDis="";
            return view('inventory.reportProfiMargin', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          else
          {
            $values= Sale::leftJoin('items', 'sales.item_id', '=', 'items.id')
            ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
            ->select('*','sales.date_added as date', 'sales.sale_price as price',DB::raw('sum(qty_given) as qty'))
            ->where('sales.location_id', session('branchid'))
            ->where('sales.payment_type', '!=' , 'Msale')
            ->where('sales.payment_type', '!=' , 'Tsale')
            ->whereBetween('sales.date_added', [$from, $to])
            //->where('sales.payment_type' , 'cash')
            //->where('sales.item_id' , $item)
            //->groupBy('sales.date_added')
            ->groupBy('sales.item_id')
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale ="All";
            $disp="";
            $userDis="";
            return view('inventory.reportProfiMargin', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
    }

    public function stockpurchase(Request $request)
    {

        $item = $request->input('items_id');
        $to = $request->input('to');
        $from = $request->input('from');
          if ( $item != 0 )
          {
            $values= Stock::leftJoin('items', 'stocks.item_id', '=', 'items.id')
            ->leftJoin('units', 'items.unit_id', '=', 'units.id')
            ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
            ->leftJoin('suppliers', 'items.supplier_id', '=', 'suppliers.id')
            ->select('*','stocks.id as stock_id','stocks.date_added as date','items.id as itemid')
            ->whereBetween('stocks.date_added', [$from, $to])
            ->where('stocks.item_id' , $item)
            ->get();

            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale ="All";
            $disp="";
            $userDis="";
            return view('inventory.reportStockPurchase', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          else
          {
            $values= Stock::leftJoin('items', 'stocks.item_id', '=', 'items.id')
            ->leftJoin('units', 'items.unit_id', '=', 'units.id')
            ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
            ->leftJoin('suppliers', 'items.supplier_id', '=', 'suppliers.id')
            ->select('*','stocks.id as stock_id','stocks.date_added as date','items.id as itemid')
            ->whereBetween('stocks.date_added', [$from, $to])
            //->where('stocks.item_id' , $item)
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale ="All";
            $disp="";
            $userDis="";
            return view('inventory.reportStockPurchase', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

}
