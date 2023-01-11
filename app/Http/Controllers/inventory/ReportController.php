<?php

namespace App\Http\Controllers\inventory;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\inventory\supplier;
use App\Models\inventory\uom;
use App\Models\inventory\unit;
use App\Models\inventory\customer;
use App\Models\User;
use App\Models\inventory\item;
use App\Models\inventory\Sale;
class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')->get();
        $custs = customer::orderBy('id', 'desc')->get();
        $valueUnits = unit::orderBy('unit_name', 'asc')->get();
        $items= item::leftJoin('units', 'items.unit_id', '=', 'units.id')
        ->leftJoin('subunits', 'items.subunit_id', '=', 'subunits.id')
        ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
        ->select('*','items.id as item_id')
        ->where('items.location_id', session('branchid'))
        ->get();
        return view('inventory.reports', compact('items','valueUnits','users','custs'));
    }
    public function getDptitemData(Request $request){

        $itemData['data'] = item::select('items.id as pid','item_name as itemname')
        ->where('items.unit_id',$request->dpt_id)
        ->get();

        return response()->json($itemData);

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
    public function sales(Request $request)
    {
        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
        $this->validate($request,[
            'items_id'=>'required',
            'unit_id'=>'required',
            'user'=>'required',
            'saleType'=>'required'
        ]);
          $dpt = $request->input('unit_id');
          $user = $request->input('user');
          $item = $request->input('items_id');
        $to = $request->input('to');
        $from = $request->input('from');
        $sale = $request->input('saleType');
          if ($dpt ==0 and $user == 0 and $item == 0 and $sale == 0)
          {
            $values= Sale::leftJoin('items', 'sales.item_id', '=', 'items.id')
            ->leftJoin('units', 'items.unit_id', '=', 'units.id')
            ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
            ->leftJoin('users', 'items.user_id', '=', 'users.id')
            ->select('*','users.name', DB::raw('sum(total_amount) as totalAmt'),DB::raw('sum(qty_given) as qty'))
            ->where('sales.location_id', session('branchid'))
            ->where('sales.payment_type', '!=' , 'MTransfer')
            ->where('sales.payment_type', '!=' , 'TableTransfer')
            ->whereBetween('sales.date_added', [$from, $to])
            ->groupBy('sales.item_id')
            ->get();
            $dpt = "All";
            $user = "All";
            $item ="All";
            $sale ="All";
            $disp="";
            $userDis="";
            return view('inventory.reportsales', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          elseif ($dpt !=0 and $user == 0 and $item == 0 and $sale == 0)
          {
            $values= Sale::leftJoin('items', 'sales.item_id', '=', 'items.id')
            ->leftJoin('units', 'items.unit_id', '=', 'units.id')
            ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
            ->leftJoin('users', 'items.user_id', '=', 'users.id')
            ->select('*', DB::raw('sum(total_amount) as totalAmt'),DB::raw('sum(qty_given) as qty'))
            ->where('sales.location_id', session('branchid'))
            ->where('sales.payment_type', '!=' , 'MTransfer')
            ->where('sales.payment_type', '!=' , 'TableTransfer')
            ->where('items.unit_id',$dpt)
            ->whereBetween('sales.date_added', [$from, $to])
            ->groupBy('sales.item_id')
            ->get();
            $units = unit::where('units.id',$dpt)->get();
            foreach($units as $data){
                $dpt = $data->unit_name;
               }

            $user = "All";
            $item ="All";
            $sale ="All";
            $disp="d-none";
            $userDis="";
            return view('inventory.reportsales', compact('values','dpt','user','item','disp','userDis','to','from','sale'));
          }
          DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
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
        //
    }
}
