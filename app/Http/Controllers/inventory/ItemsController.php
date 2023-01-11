<?php

namespace App\Http\Controllers\inventory;

use App\Models\inventory\supplier;
use App\Models\inventory\uom;
use App\Models\inventory\unit;
use App\Models\inventory\subUnit;
use App\Models\inventory\item;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
class ItemsController extends Controller
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
        return view('inventory.items', compact('values'));

    }
    public function import()
    {
        DB::statement("SET foreign_key_checks=0"); 
        Excel::import(new ProductsImport, request()->file('file'));
        DB::statement("SET foreign_key_checks=1"); 

        return back()->with('success', 'Record Successfully imported !!');;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Ripon@Tech441f! Ripon@tech2022! ked441f! Ripon@mail2022, moses.M441f!, Ked441f!2022
        $valueUnites = unit::orderBy('unit_name', 'asc')->get();
        $uoms = uom::orderBy('uom_name', 'asc')->get();
        $suppliers = supplier::orderBy('sup_name', 'asc')->get();
        $syscode = random_int(1000, 9999).time();
        return view('inventory.newItem', compact('valueUnites', 'uoms','suppliers','syscode'));
    }

    public function getSubUnits(Request $request)
        {
        $subUnits = DB::table("subunits")
        ->where("unit_id",$request->unit_id)
        ->pluck("subunit_name","id");
        return response()->json($subUnits);
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
        // 'subunit_id'=>'required',
        'cost_price'=>'required|numeric',
        'uom_id'=>'required',
        'supplier_id'=>'required',
        'color'=>'required',
        'margin'=>'required|numeric',
        'description'=>'string',
        'item_name'=>'required',
        'sale_price'=>'required|numeric'
    ]);

    $value = new item();

    $value->item_name = $request->input('item_name');
    $value->unit_id = $request->input('unit_id');
    $value->subunit_id = $request->input('subunit_id');
    $value->cost_price = $request->input('cost_price');
    $value->sale_price = $request->input('sale_price');
    $value->margin = $request->input('margin');
    $value->uom_id = $request->input('uom_id');
    $value->supplier_id = $request->input('supplier_id');
    $value->model_no = $request->input('model_no');
    $value->color = $request->input('color');
    $value->syscode = $request->input('syscode');
    $value->item_barcode = $request->input('item_barcode');
    $value->location_id = session('branchid');
    $value->description = $request->input('description');
    $value->date_added = date('Y-m-d');
    $value->user_id = auth()->user()->id;
    $value->save();
    return redirect('inventory/items')->with('success', 'Record Successfully added !!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $units = unit::orderBy('name', 'asc')->get();
        $uoms = uom::orderBy('uom_name', 'asc')->get();
        $suppliers = supplier::orderBy('sup_name', 'asc')->get();
        return view('inventdashboard.EditItemddd', compact('units', 'uoms','suppliers','stores'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $valueUnites = unit::orderBy('unit_name', 'asc')->get();
        $uoms = uom::orderBy('uom_name', 'asc')->get();
        $suppliers = supplier::orderBy('sup_name', 'asc')->get();
        $values= item::leftJoin('units', 'items.unit_id', '=', 'units.id')
        ->leftJoin('subunits', 'items.subunit_id', '=', 'subunits.id')
        ->leftJoin('uoms', 'items.uom_id', '=', 'uoms.id')
        ->leftJoin('suppliers', 'items.supplier_id', '=', 'suppliers.id')
        ->select('*','items.id as item_id')
        ->where('items.id', $id)
        ->get();
        return view('inventory.editItem', compact('valueUnites', 'uoms','suppliers','values'));
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
            'unit_id'=>'required',
            'subunit_id'=>'required',
            'cost_price'=>'required|numeric',
            'uom_id'=>'required',
            'supplier_id'=>'required',
            'model_no'=>'required',
            'color'=>'required',
            'description',
            'item_name'=>'required',

        ]);
        $value = item::find($id);
        $value->item_name = $request->input('item_name');
        $value->unit_id = $request->input('unit_id');
        $value->subunit_id = $request->input('subunit_id');
        $value->cost_price = $request->input('cost_price');
        $value->sale_price = $request->input('sale_price');
        $value->margin = $request->input('margin');
        $value->uom_id = $request->input('uom_id');
        $value->supplier_id = $request->input('supplier_id');
        $value->model_no = $request->input('model_no');
        $value->color = $request->input('color');
        $value->syscode = $request->input('syscode');
        $value->item_barcode = $request->input('item_barcode');
        $value->description = $request->input('description');
        //$value->user_id = auth()->user()->id;
        $value->update();
        return  redirect()->back()->with('success', 'Record Successfully updated !!');
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
