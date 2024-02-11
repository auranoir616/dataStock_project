<?php

use App\Http\Controllers\Order;
use App\Http\Controllers\Users;
use App\Http\Controllers\DataOut;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\DataDisplay;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller_Order;
use App\Http\Controllers\Controller_ReceiveGoods;
use App\Http\Controllers\Controller_PurchaseOrder;
use App\Http\Controllers\Controller_Data;
use App\Http\Controllers\Controller_Shipping;
use App\Http\Controllers\Controller_Return;
use App\Http\Controllers\Controller_Broken;




/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//! route utama
Route::get('/', function(){
    return view('loginpage');
});
Route::get('/suppliers', [Controller_Data::class, 'GetDataSuppliers']);
Route::post('/suppliers-add', [Controller_Data::class, 'AddDataSupplers']);
Route::get('/productlist', [Controller_Data::class, 'GetDataSKU']);
Route::post('/productlist-add', [Controller_Data::class, 'AddDataSKU']);
Route::get('/searchproduct', [Controller_Data::class, 'searchproduct']);


//!ROute receive GOODs
Route::get('/receiveGoods',  [Controller_ReceiveGoods::class, 'receiveGoods']);
Route::post('/dataIn-add',[Controller_ReceiveGoods::class, 'dataInPost']);
Route::get('/dataIn-new',[Controller_ReceiveGoods::class, 'dataInForm']);
Route::get('/dataIn-addtotable',[Controller_ReceiveGoods::class, 'dataInAddtoTable']);
Route::get('/dataIn-view/{IdItem}',[Controller_ReceiveGoods::class, 'dataInView']);
Route::get('/dataIn-delete/{IdItem}-{SKUItem}',[Controller_ReceiveGoods::class, 'dataInDelete']);
Route::get('/dataIn-edit{IdItem}',[Controller_ReceiveGoods::class, 'dataInEdit']);



//! ROUTE PO
Route::get('/purchaseOrder',[Controller_PurchaseOrder::class, 'dataPOGet']);
Route::get('/dataPO-new/{IDPO}',[Controller_PurchaseOrder::class, 'dataPOForm']);
Route::post('/dataPO-add',[Controller_PurchaseOrder::class, 'dataPOAdd']);
Route::get('/dataPO-view/{IDPO}',[Controller_PurchaseOrder::class, 'dataPOView']);
Route::get('/dataPO-delete/{IDPO}',[Controller_PurchaseOrder::class, 'dataPODelete']);
Route::get('/dataPO-TableDelete/{IdItem}',[Controller_PurchaseOrder::class, 'dataPOTableDelete']);
Route::get('/dataPOView-delete/{IdItem}',[Controller_PurchaseOrder::class, 'dataPOViewDelete']);
Route::get('/dataPOView-editForm/{IdItem}',[Controller_PurchaseOrder::class, 'dataPOViewEditForm']);
Route::put('/dataPO-editStatus/{IDPO}',[Controller_PurchaseOrder::class, 'dataPOEditStatus']);
Route::put('/dataPOView-editSave/{IdItem}', [Controller_PurchaseOrder::class, 'dataPOViewEditSave']);
Route::put('/dataPO-addPrice/{IDPO}', [Controller_PurchaseOrder::class, 'dataPOAddPrice']);

//! ROUTE ORDER
Route::get('/order-suggestions', [Controller_Order::class, 'SuggestionSKU']);
Route::get('/order-getItem/{SKU}', [Controller_Order::class, 'GetItem']);
Route::post('/order-add', [Controller_Order::class, 'AddOrder']);
Route::get('/order/{ORID}', [Controller_Order::class, 'dataOrder']);
Route::put('/order-submit/{ORID}', [Controller_Order::class, 'AddPriceTax']);
Route::get('/order-deleteItem/{idItem}-{SKUItem}', [Controller_Order::class, 'dataOrderTableDelete']);
Route::get('/order-history', [Controller_Order::class, 'dataOrderHistory']);
Route::get('/order-view/{ORID}', [Controller_Order::class, 'dataOrderView']);

//! route Shipping
Route::get('/shipping-new/{IDSH}', [Controller_Shipping::class, 'dataShippingForm']);
Route::get('/shipping', [Controller_Shipping::class, 'dataShipping']);
Route::get('/shipping-suggestions', [Controller_Shipping::class, 'SuggestionSKU']);
Route::post('/shipping-add', [Controller_Shipping::class, 'addDataShipping']);
Route::get('/shipping-delete/{IdItem}-{SKUItem}', [Controller_Shipping::class, 'dataShippingTableDelete']);
Route::put('/shipping-submit/{IDSH}', [Controller_Shipping::class, 'dataShippingSubmit']);
Route::put('/shipping-editStatus/{IDSH}', [Controller_Shipping::class, 'dataShippingStatus']);
Route::get('/shipping-view/{IDSH}',[Controller_Shipping::class, 'dataShippingView']);

//!route Return
Route::get('/return',[Controller_Return::class, 'dataReturn']);
Route::get('/return-receive/{IDSH}',[Controller_Return::class, 'dataReturnReceive']);
Route::post('/return-add',[Controller_Return::class, 'dataReturnPost']);
Route::get('/return-new',[Controller_Return::class, 'dataReturnForm']);
Route::get('/return-view/{IDRE}',[Controller_Return::class, 'dataReturnView']);

//! route Broken
Route::get('/broken-form/{IDBR}', function(){
    if(auth()->check()){
        return view('brokenStock');
    }else{
    return view('loginpage');
    }
});

Route::get('/broken-history',[Controller_Broken::class, 'dataBrokenStock']);
Route::post('/broken-new',[Controller_Broken::class, 'dataBrokenNew']);
Route::get('/broken-view/{IDBR}',[Controller_Broken::class, 'dataBrokenView']);
Route::get('/broken-Select',[Controller_Broken::class, 'dataBrokenSelect']);
Route::get('/broken-add/{IDRE}/{SKU}',[Controller_Broken::class, 'dataBrokenAddFromReturn']);

//!route stock
Route::get('/currentStock', [Controller_Data::class, 'currentStock']);


//! route not done

Route::get('/dashboard', function(){
    if(auth()->check()){
        return view('dashboard');
    }else{
    return view('loginpage');
    }

});

Route::get('/topsellingproduct', [Controller_Data::class, 'TopSellingProduct']);
Route::get('/stockcategory', [Controller_Data::class, 'StockEachCategories']);
Route::get('/totalselling', [Controller_Data::class, 'TotalSelling']);
Route::get('/lowstockalert', [Controller_Data::class, 'LowStockAlert']);






//! route user
Route::post('/addNewUser', [Users::class, 'AddNewUser']);
Route::post('/loginUser', [Users::class, 'login']);

Route::get('/addUserForm',function(){
    if(auth()->check()){
        return view('newUser'); 
    }else{
    return view('loginpage');
    }

});
Route::get('/listUsers',[Users::class, 'listUsers']);
Route::get('/logout', [Users::class, 'logout']);

Route::get('/editUser-form/{dataUser}',  [Users::class, 'editUserForm']);

Route::put('/editUser/{dataUser}', [Users::class, 'editUser']);
Route::get('/deleteUser/{dataUser}', [Users::class, 'deleteUser']);

