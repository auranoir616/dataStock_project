<?php

namespace App\Http\Controllers;

use App\Models\In;
use App\Models\SKU;
use App\Models\Items;
use App\Models\Order;
use App\Models\Broken;
use App\Models\ReturnIn;
use App\Models\Shipping;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Controller_Data extends Controller
{
 //!curent stock
 public function currentStock()
 {
     if (auth()->check()) {
         $dataSKU = DB::table('items')->pluck('SKU'); // Ambil semua SKU dari tabel items
         
         $dataIn = In::whereIn('SKU', $dataSKU)
         ->select('SKU', DB::raw('MAX(updated_at) as last_in'))
         ->groupBy('SKU')
         ->get();
         
         $dataOrder = Order::whereIn('SKU', $dataSKU)
         ->select('SKU', DB::raw('MAX(updated_at) as last_out'))
         ->groupBy('SKU')
         ->get();
         
         $dataShipping = Shipping::whereIn('SKU', $dataSKU)
         ->select('SKU', DB::raw('MAX(updated_at) as last_out'))
         ->groupBy('SKU')
         ->get();
         
         $dataReturn = ReturnIn::whereIn('SKU', $dataSKU)
         ->select('SKU', DB::raw('MAX(updated_at) as last_out'))
         ->groupBy('SKU')
         ->get();
         
         $dataBroken = Broken::whereIn('SKU', $dataSKU)
         ->select('SKU', DB::raw('SUM(quantity) as qty'))
         ->groupBy('SKU')
         ->get();

        $dataItems = DB::table('items')->orderBy('updated_at', 'desc')->paginate(10);
        return view('currentStock', [
             'dataIn' => $dataIn,
             'dataOrder' => $dataOrder,
             'dataItems' => $dataItems,
             'dataShipping' => $dataShipping,
             'dataReturn' =>$dataReturn,
             'dataBroken' =>$dataBroken
         ]);
     } else {
         return redirect('/');
     }
 }
 //! supplier
    public function GetDataSuppliers(){
        if(!auth()->check()){
            return redirect('/');
        }else{
        $suppliers = DB::table('supplier')->orderBy('id', 'desc')->paginate(5);
        return view('suppliers',compact('suppliers'));
        }
    }
    public function AddDataSupplers(Request $request){
        if(!auth()->check()){
            return redirect('/');
        }else{
            $dataSuppliersReq = $request->validate([
                'supName' => 'required',
                'supAddress' => 'required',
                'supPhone' => 'required',
                'supEmail' => 'nullable',
            ]);
            $dataSuppliers = [
                'supplier_name' => $request->supName,
                'supplier_address' => $request->supAddress,
                'supplier_phone' => $request->supPhone,
                'supplier_email' => $request->supEmail,
            ];

            $saveDataSuppliers = Supplier::create($dataSuppliers);
            if($saveDataSuppliers){
                return redirect()->back()->with('success','New Suppler Added Successfully');
            }else{
                return redirect()->back()->with('error','Failed Add Supplier Data');
            }

        }
    }
//! SKU
    public function GetDataSKU(){
        if(!auth()->check()){
            return redirect('/');
        }else{
            $listSKU = DB::table('sku')->paginate(10);
        return view('productList',compact('listSKU'));
    }   

    }
    public function AddDataSKU(Request $request){
        if(!auth()->check()){
            return redirect('/');
        }else{
            $dataSKUReq = $request->validate([
                'addSKU' => 'required',
                'addProduct' => 'required',
            ]);
            $dataSKU = [
                'SKU' => $request->addSKU,
                'product' => $request->addProduct,
            ];

            $saveDataSKU = SKU::create($dataSKU);
            if($saveDataSKU){
                return redirect()->back()->with('success','New Product Added Successfully');
            }else{
                return redirect()->back()->with('error','Failed to Add Product');
            }

        }

    }   
    public  function searchproduct(Request $request){
        $query = $request->input('query');
        $dataItems = Items::where('name','like',"%$query%")->get();
        $dataShipping = Shipping::where('product','like',"%$query%")->get();
        $dataOrder = Order::where('product','like',"%$query%")->get();
        $dataIn = In::where('product_name','like',"%$query%")->get();
        $dataReturn = ReturnIn::where('product','like',"%$query%")->get();
        $dataPO = DB::table('purchase_order')->join('items', 'purchase_order.SKU', '=', 'items.SKU')

        ->where('items.name','like',"%$query%")->select('items.name as product_name', 'purchase_order.*')->get();
// dd($dataOrder);
        return view('searchResult', compact('dataReturn','dataItems','dataShipping','dataOrder','dataIn','dataPO'));

   }


    }
    
    

