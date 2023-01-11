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

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (session()->has('branch')) {
           $location = session('branchdata');
           $Tmachinesales = Sale::where('location_id',session('branchid'))->where('payment_type','Msale')->sum('total_amount');
           $TTablesales = Sale::where('location_id',session('branchid'))->where('payment_type','Tsale')->sum('total_amount');
           $TCashsales = Sale::where('location_id',session('branchid'))->where('payment_type','cash')->sum('total_amount');
           $Tsales = Sale::where('location_id',session('branchid'))->where('payment_type', '!=' , 'MTransfer')
           ->where('payment_type', '!=' , 'TableTransfer')->sum('total_amount');

           $tdate = date('Y-m-d');
           $syear = date("Y");
           $smonth = date("M-Y");
           $sweek = date("Y-M-W");

           $Todaysales = Sale::where('location_id',session('branchid')) ->where('date_added', $tdate)->where('payment_type', '!=' , 'MTransfer')
           ->where('payment_type', '!=' , 'TableTransfer')->sum('total_amount');
           $weeksales = Sale::where('location_id',session('branchid'))
           ->where('sale_week', $sweek)
           ->where('payment_type', '!=' , 'MTransfer')
           ->where('payment_type', '!=' , 'TableTransfer')
           ->sum('total_amount');

           $monthsales = Sale::where('location_id',session('branchid'))
           ->where('sale_month', $smonth)
           ->where('payment_type', '!=' , 'MTransfer')
           ->where('payment_type', '!=' , 'TableTransfer')
           ->sum('total_amount');

           $yearsales = Sale::where('location_id',session('branchid'))
           ->where('sale_year', $syear)
           ->where('payment_type', '!=' , 'MTransfer')
           ->where('payment_type', '!=' , 'TableTransfer')
           ->sum('total_amount');

           DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
           $barsales = Sale::where('location_id',session('branchid'))
           ->where('payment_type', '!=' , 'MTransfer')
           ->where('payment_type', '!=' , 'TableTransfer')
           ->groupBy(['sale_month'])->select('sale_month', DB::raw('sum(total_amount) as totalamount'))
            ->limit(12)
           ->get();

           $machineDsales = Sale::where('location_id',session('branchid'))
           ->where('payment_type', 'Msale')
           ->groupBy(['date_added'])->select('date_added', DB::raw('sum(total_amount) as totalamount'))
            ->limit(5)
           ->get();

           $TableDsales = Sale::where('location_id',session('branchid'))
           ->where('payment_type', 'Tsale')
           ->groupBy(['date_added'])->select('date_added', DB::raw('sum(total_amount) as totalamount'))
            ->limit(5)
           ->get();

           $smDsales = Sale::where('location_id',session('branchid'))
           ->where('payment_type','cash')
           //->orWhere('payment_type', 'invo')
           ->groupBy(['date_added'])->select('date_added', DB::raw('sum(total_amount) as totalamount'))
            ->limit(5)
           ->get();
           DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
//-------------------------------------------total sales chart data-----------------------------
        if (count($barsales)>0){
           foreach($barsales as $data){
            $month[] = $data->sale_month;
            $gamount[] = $data->totalamount;
           }
           $gmonth= json_encode($month,JSON_NUMERIC_CHECK);
            $gamount = json_encode($gamount,JSON_NUMERIC_CHECK);
          }
           else{
                $gmonth=0;
                $gamount=0;

            }
//---------------------------------machine chart geting daily sales-----------------------------------
            if (count($machineDsales)>0){
             foreach($machineDsales as $data){
            $mday[] = $data->date_added;
            $mdamount[] = $data->totalamount;
            }
            $mday= json_encode($mday,JSON_NUMERIC_CHECK);
            $mdamount = json_encode($mdamount,JSON_NUMERIC_CHECK);
            }
             else{
                $mday=0;
                $mdamount=0;

            }
//--------------------------------------table chart data------------------------------------
            if (count($TableDsales)>0){
            foreach($TableDsales as $data){
                $tday[] = $data->date_added;
                $tdamount[] = $data->totalamount;
                }
                $tday= json_encode($tday,JSON_NUMERIC_CHECK);
                $tdamount = json_encode($tdamount,JSON_NUMERIC_CHECK);
            }
             else{
                $tday=0;
                $tdamount=0;

            }
//--------------------------------------table chart data------------------------------------
            if (count($smDsales)>0){
            foreach($smDsales as $data){
                $smday[] = $data->date_added;
                $smdamount[] = $data->totalamount;
                }
                $smday= json_encode($smday,JSON_NUMERIC_CHECK);
                $smdamount = json_encode($smdamount,JSON_NUMERIC_CHECK);
            }
            else{
                $smday=0;
                $smdamount=0;

            }

//return  $barsales;
            return view('inventory.dashboard',compact('smday','smdamount','tday','tdamount','mday','mdamount','gmonth','gamount','location','TCashsales','Tmachinesales','TTablesales','Tsales','Todaysales','weeksales','monthsales','yearsales'));
            }else{
                return redirect('inventory/select/location')->with('error', 'Please select a location');
            }

    }

    public function index2()
    {
        if (session()->has('branch')) {
           $location = session('branchdata');
           $Tmachinesales = Sale::where('location_id',session('branchid'))->where('payment_type','Msale')->sum('total_amount');
           $TTablesales = Sale::where('location_id',session('branchid'))->where('payment_type','Tsale')->sum('total_amount');
           $TCashsales = Sale::where('location_id',session('branchid'))->where('payment_type','cash')->sum('total_amount');
           $Tsales = Sale::where('location_id',session('branchid'))
           ->where('payment_type', '!=' , 'MTransfer')
           ->where('payment_type', '!=' , 'TableTransfer')
           ->sum('total_amount');

           $tdate = date('Y-m-d');
           $syear = date("Y");
           $smonth = date("M-Y");
           $sweek = date("Y-M-W");


           $Todaysales = Sale::where('location_id',session('branchid'))
           ->where('date_added', $tdate)
           ->where('payment_type', '!=' , 'MTransfer')
           ->where('payment_type', '!=' , 'TableTransfer')
           ->sum('total_amount');
           $weeksales = Sale::where('location_id',session('branchid'))
           ->where('sale_week', $sweek)
           ->where('payment_type', '!=' , 'MTransfer')
           ->where('payment_type', '!=' , 'TableTransfer')
           ->sum('total_amount');

           $monthsales = Sale::where('location_id',session('branchid'))
           ->where('sale_month', $smonth)
           ->where('payment_type', '!=' , 'MTransfer')
           ->where('payment_type', '!=' , 'TableTransfer')
           ->sum('total_amount');

           $yearsales = Sale::where('location_id',session('branchid'))
           ->where('sale_year', $syear)
           ->where('payment_type', '!=' , 'MTransfer')
           ->where('payment_type', '!=' , 'TableTransfer')
           ->sum('total_amount');




           DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''));");
           $barsales = Sale::where('location_id',session('branchid'))
           ->where('payment_type', '!=' , 'MTransfer')
           ->where('payment_type', '!=' , 'TableTransfer')
           ->groupBy(['sale_month'])->select('sale_month','payment_type', DB::raw('sum(total_amount) as totalamount'))

           ->get();
           DB::statement("SET sql_mode=(SELECT CONCAT(@@sql_mode, ',ONLY_FULL_GROUP_BY'));");
           foreach($barsales as $data){
            $month[] = $data->sale_month;
            $amount[] = $data->totalamount;
           }


           $year= json_encode($month,JSON_NUMERIC_CHECK);
            $user = json_encode($amount,JSON_NUMERIC_CHECK);

           return view('inventory.layouts.charts',compact('year','user'));

            //return view('inventory.layouts.charts',compact('location','TCashsales','Tmachinesales','TTablesales','Tsales','Todaysales','weeksales','monthsales','yearsales'));
            }else{
                return redirect('inventory/select/location')->with('error', 'Please select a location');
            }

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
