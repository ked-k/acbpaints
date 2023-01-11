<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisteredUserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\inventory\DashboardController::class, 'index'])->middleware(['auth','role:superadministrator|administrator|user'])->name('dashboard');
Route::get('/management/dashboard',[RegisteredUserController::class, 'index'])->middleware(['auth,','role:superadministrator'])->name('manage.index');
Route::group(['namespace' => 'inventory','middleware' => ['auth','role:superadministrator|administrator|user'], 'prefix' => 'inventory' ], function() {
    Route::get('/select/location', [App\Http\Controllers\inventory\SelectLocationController::class, 'index']);
    Route::post('/location/add', [App\Http\Controllers\inventory\SelectLocationController::class, 'store']);
    Route::get('/location/{id}', [App\Http\Controllers\inventory\SelectLocationController::class, 'show']);
    Route::get('/dashboard', [App\Http\Controllers\inventory\DashboardController::class, 'index']);

    Route::get('/charts', [App\Http\Controllers\inventory\DashboardController::class, 'index2']);

    //------------------------------------location routes-------------------------------------------------
    Route::get('/branches', [App\Http\Controllers\inventory\SelectLocationController::class, 'index2']);
    Route::post('/branches/add', [App\Http\Controllers\inventory\SelectLocationController::class, 'store']);
    Route::get('/branches/delete/{id}', [App\Http\Controllers\inventory\SelectLocationController::class, 'destroy']);
    Route::post('/branches/update/{id}', [App\Http\Controllers\inventory\SelectLocationController::class, 'update']);
    //------------------------------------units routes-------------------------------------------------
    Route::get('/units', [App\Http\Controllers\inventory\UnitsController::class, 'index']);
    Route::post('/Units/add', [App\Http\Controllers\inventory\UnitsController::class, 'store']);
    Route::get('/units/delete/{id}', [App\Http\Controllers\inventory\UnitsController::class, 'destroy']);
    Route::post('/units/update/{id}', [App\Http\Controllers\inventory\UnitsController::class, 'update']);
      //----------------------------------Subcategories routes---------------------------------------------
    Route::get('/Subunits', [App\Http\Controllers\inventory\SubUnitsController::class, 'index']);
    Route::post('/subunits/add', [App\Http\Controllers\inventory\SubUnitsController::class, 'store']);
    Route::get('/Subunits/delete/{id}', [App\Http\Controllers\inventory\SubUnitsController::class, 'destroy']);
    Route::post('/Subunits/update/{id}', [App\Http\Controllers\inventory\SubUnitsController::class, 'update']);

    //-----------------------------------------UOM ROUTES---------------------------------------------------
    Route::get('/uom', [App\Http\Controllers\inventory\UomController::class, 'index']);
    Route::post('/uom/add', [App\Http\Controllers\inventory\UomController::class, 'store']);
    Route::get('/uom/delete/{id}', [App\Http\Controllers\inventory\UomController::class, 'destroy']);
    Route::post('/uom/update/{id}', [App\Http\Controllers\inventory\UomController::class, 'update']);

    //----------------------------------supplier routes---------------------------------------------
    Route::get('/suppliers', [App\Http\Controllers\inventory\SuppliersController::class, 'index']);
    Route::post('/suppliers/add', [App\Http\Controllers\inventory\SuppliersController::class, 'store']);
    Route::get('/supplier/delete/{id}', [App\Http\Controllers\inventory\SuppliersController::class, 'destroy']);
    Route::post('/supplier/update/{id}', [App\Http\Controllers\inventory\SuppliersController::class, 'update']);

    //----------------------------------supplier routes---------------------------------------------
    Route::get('/customers', [App\Http\Controllers\inventory\CustomersController::class, 'index']);
    Route::post('/customers/add', [App\Http\Controllers\inventory\CustomersController::class, 'store']);
    Route::get('/customers/delete/{id}', [App\Http\Controllers\inventory\CustomersController::class, 'destroy']);
    Route::post('/customers/update/{id}', [App\Http\Controllers\inventory\CustomersController::class, 'update']);

    //-------------------------------------Item routes----------------------------------------------
    Route::get('/item/new', [App\Http\Controllers\inventory\ItemsController::class, 'create']);
    Route::get('/items', [App\Http\Controllers\inventory\ItemsController::class, 'index']);
    Route::post('/item/add', [App\Http\Controllers\inventory\ItemsController::class, 'store']);
    Route::get('/item/edit/{id}', [App\Http\Controllers\inventory\ItemsController::class, 'edit']);
    Route::post('/item/update/{id}', [App\Http\Controllers\inventory\ItemsController::class, 'update']);
    Route::post('/products/import', [App\Http\Controllers\inventory\ItemsController::class, 'import']);
    Route::get('/getSubUnits',[App\Http\Controllers\inventory\ItemsController::class, 'getSubUnits'])->name('getSubUnits');

    //----------------------------------stock routes---------------------------------------------
    Route::get('/stockLevels', [App\Http\Controllers\inventory\StockController::class, 'index']);
    Route::get('/stock/new/{id}', [App\Http\Controllers\inventory\StockController::class, 'create']);
    Route::post('/add-stock', [App\Http\Controllers\inventory\StockController::class, 'store']);
    Route::get('/delete-stockitem/{id}', [App\Http\Controllers\inventory\StockController::class, 'destroy']);
    Route::get('/delete-stock/{id}', [App\Http\Controllers\inventory\StockController::class, 'destroystock']);
    Route::post('/update-stock/{id}', [App\Http\Controllers\inventory\StockController::class, 'update']);
    Route::get('/getItem', [App\Http\Controllers\inventory\StockController::class, 'getitemData']);
    Route::post('/save-stock', [App\Http\Controllers\inventory\StockController::class, 'saveStock']);
    Route::get('/view-stock/{id}', [App\Http\Controllers\inventory\StockController::class, 'viewstockdetails']);
    Route::get('/stock/documents', [App\Http\Controllers\inventory\StockController::class, 'allmaindoc']);
    Route::get('/confirmedStock', [App\Http\Controllers\inventory\StockController::class, 'confirmed']);
    Route::get('/unconfirmedStock', [App\Http\Controllers\inventory\StockController::class, 'unconfirmed']);

     //-------------------------------------sales routes----------------------------------------------
     Route::get('/sales/main', [App\Http\Controllers\inventory\SalesController::class, 'index']);
     Route::get('/sale/new/{id}', [App\Http\Controllers\inventory\SalesController::class, 'create']);
     Route::post('/newsale/additem', [App\Http\Controllers\inventory\SalesController::class, 'store']);
     Route::post('/sale/savenew', [App\Http\Controllers\inventory\SalesController::class, 'update']);
     Route::post('/sale/saveprint', [App\Http\Controllers\inventory\SalesController::class, 'updatePrint']);
     Route::post('sale-item/delete', [App\Http\Controllers\inventory\SalesController::class, 'destroyItem']);
     Route::get('/getitemQty',[App\Http\Controllers\inventory\SalesController::class, 'getitemQty'])->name('getitemQty');
     Route::get('/print/reciept/{id}', [App\Http\Controllers\inventory\SalesController::class, 'print']);
     Route::get('/sales/print/{id}', [App\Http\Controllers\inventory\SalesController::class, 'show']);
     Route::get('/history/main', [App\Http\Controllers\inventory\SalesController::class, 'salesHistory']);
     Route::get('/history/Yesterday', [App\Http\Controllers\inventory\SalesController::class, 'salesHistoryYesturday']);
     Route::get('/history/today', [App\Http\Controllers\inventory\SalesController::class, 'salesHistoryToday']);
     Route::get('/history/transfer', [App\Http\Controllers\inventory\SalesController::class, 'TransferHistory']);
     Route::get('/history/main/unconfirmed', [App\Http\Controllers\inventory\SalesController::class, 'salesHistoryUnconfirmed']);
     Route::get('/history/main/confirmed', [App\Http\Controllers\inventory\SalesController::class, 'salesHistoryconfirmed']);

     //----------------------------------machine route--------------------------------------------------------
     Route::get('/machine/stockLevels', [App\Http\Controllers\inventory\MachineController::class, 'index']);
     Route::post('/machine/additem', [App\Http\Controllers\inventory\MachineController::class, 'store']);
     Route::get('/sale/machine/{id}', [App\Http\Controllers\inventory\MachineController::class, 'create']);
     Route::post('/machinesale/additem', [App\Http\Controllers\inventory\MachineController::class, 'storemachineSaleItem']);
     Route::get('/getMachineItem',[App\Http\Controllers\inventory\MachineController::class, 'getMachineItem'])->name('getMachineItem');
     Route::post('/machineIetem/update/{id}', [App\Http\Controllers\inventory\MachineController::class, 'update']);

    //----------------------------------machine route--------------------------------------------------------
    Route::get('/table/stockLevels', [App\Http\Controllers\inventory\TableController::class, 'index']);
    Route::post('/table/additem', [App\Http\Controllers\inventory\TableController::class, 'store']);
    Route::get('/sale/tabe/{id}', [App\Http\Controllers\inventory\TableController::class, 'create']);
    Route::post('/tablesale/additem', [App\Http\Controllers\inventory\TableController::class, 'storeTableSaleItem']);
    Route::get('/getTaleItem',[App\Http\Controllers\inventory\TableController::class, 'getTaleItem'])->name('getTaleItem');
    Route::post('/tableIetem/update/{id}', [App\Http\Controllers\inventory\TableController::class, 'update']);

    //----------------------------Expenditures routes------------------------------------------------
    Route::get('expenditures', [App\Http\Controllers\inventory\ExpenditureController::class, 'index']);
    Route::get('expenditures/delete/{id}', [App\Http\Controllers\inventory\ExpenditureController::class, 'destroy']);
    Route::post('/expenditures/add', [App\Http\Controllers\inventory\ExpenditureController::class, 'store']);

     //----------------------------------report route--------------------------------------------------------
     Route::get('/reports', [App\Http\Controllers\inventory\ReportController::class, 'index']);
     Route::post('/report/view/sales', [App\Http\Controllers\inventory\ReportController::class, 'sales']);
     Route::post('/report/view/dailysales', [App\Http\Controllers\inventory\DailyReportController::class, 'dailysales']);
     Route::post('/report/view/profitMargin', [App\Http\Controllers\inventory\DailyReportController::class, 'profitmargin']);
     Route::post('/report/view/stockpurchase', [App\Http\Controllers\inventory\DailyReportController::class, 'stockpurchase']);
     Route::get('/getDptitemData',[App\Http\Controllers\inventory\ReportController::class, 'getDptitemData'])->name('getDptitemData');
    
    //----------------------------customer transactions-------------------------------------------------------------
    Route::get('/deposit/new', [App\Http\Controllers\inventory\CustomersController::class, 'receive']);
     Route::get('/withdraw/new', [App\Http\Controllers\inventory\CustomersController::class, 'give']);
     Route::get('/Deposits/getcust', [App\Http\Controllers\inventory\CustomersController::class, 'getcust']);
     Route::post('/Deposits/add', [App\Http\Controllers\inventory\CustomersController::class, 'deposit']);
     Route::post('/withdraw/add', [App\Http\Controllers\inventory\CustomersController::class, 'withdraw']);

     Route::get('/customer/transactions', [App\Http\Controllers\inventory\CustomersController::class, 'transactions']);

     
});
Route::get('/management/dashboard',[RegisteredUserController::class, 'index'])->middleware(['auth'])->name('manage.index');
require __DIR__.'/auth.php';
