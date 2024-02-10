<?php

namespace App\Http\Controllers;

use App\Models\In;
use App\Models\PO;
use App\Models\Items;
use App\Models\Supplier;
use Illuminate\Http\Request;
use App\Http\Requests\Req_IN;
use App\Http\Requests\Req_PO;
use App\Http\Requests\Req_EditPO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class Controller_PurchaseOrder extends Controller
{
        //!Route Purchase Order
        public function dataPOForm($IDPO){
            if(auth()->check()){
                $dataSuppliers = Supplier::pluck('supplier_name');
                $dataSKU= DB::table('items')->pluck('SKU');
                $tempTablePO = DB::table('purchase_order')->where('purchase_id', $IDPO)->get();
            return view('purchaseOrderForm',compact('dataSKU','dataSuppliers','tempTablePO'));
            }else{
                return redirect('/');
            }
        }
        public function dataPOGet(){
            if(auth()->check()){
                $dataPOIds = DB::table('purchase_order')->select('purchase_id')->distinct()->get();
                $dataPO = collect();
                foreach ($dataPOIds as $row) {
                $purchaseId = $row->purchase_id;
                $dataUnique = DB::table('purchase_order')->where('purchase_id', $purchaseId)->first();
                if($dataUnique){
                $dataPO->push($dataUnique);
                }
            }
            $dataPOQuery = DB::table('purchase_order')->whereIn('id', $dataPO->pluck('id'));
            $dataPO = $dataPOQuery->orderBy('created_at','desc')->paginate(7);
                return view('purchaseOrder',compact('dataPO'));   
    
            }else{
                return redirect('/');
            }
        }
    public function dataPOAdd(Req_PO $request){
        if (!auth()->check()) {
            return view('loginpage');
        }
        $dataPO = $request->validated();
        $file = $request->file('POFile');
        $saveDataPO = [
            'create_date' => $dataPO['POCreateDate'],
            'invoice' => $dataPO['POInvoice'],
            'supplier' => $dataPO['POSupplier'],
            'SKU' => $dataPO['POSKU'],
            'quantity' => $dataPO['POQuantity'],
            'notes' => $dataPO['PONotes'] ?? null,
            'purchase_id' => $request['POId'],
            'price'=> $dataPO['POPrice']
        ];
        // dd($dataPO, $saveDataPO );
        if ($request->hasFile('POFile') && $file->isValid() && in_array($file->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'webp'])) {
            $fileName = time() . "_" . $request['POId'] .$file->getClientOriginalName() ;
            $folder_upload = 'data_file';
            if ($file->move($folder_upload, $fileName)) {
                $saveDataPO['file'] = $fileName;
            } else {
                return redirect()->back()->with('error', 'save data gagal');
            }
        }
        if (PO::create($saveDataPO)) {
            return redirect()->back()->with('success', 'save data berhasil');
        }
        return redirect()->back()->with('error', 'upload data gagal');
    }
    
        public function dataPOView($IDPO){
            if(auth()->check()){

            $dataPOView = DB::table('purchase_order')
            ->join('Items', 'purchase_order.SKU', '=', 'Items.SKU')
            ->where('purchase_order.purchase_id', $IDPO)
            ->select('Items.*', 'purchase_order.*')
            ->paginate(5);
                return view('purchaseOrderView',compact('dataPOView','IDPO'));   
    
            }else{
                return redirect('/');
            }
      
        }
        public function dataPODelete($IDPO){
            if(auth()->check()){
                $dataPODel = DB::table('purchase_order')->where('purchase_id', $IDPO)->delete();
                if($dataPODel){
                return redirect()->back()->with('success','save data berhasil');
                }else{
                    return redirect()->back()->with('error','gagal delete data');
     
                }
            }else{
                return redirect('/');
    
            }
        }
        public function dataPOTableDelete($IdItem){
            if(auth()->check()){
                $dataPODel = DB::table('purchase_order')->where('id', $IdItem)->delete();
                if($dataPODel){
                    return redirect()->back()->with('success','delete data berhasil');
                }else {
                    return redirect()->back()->with('error','delete data gagal');
                }
            }else{
                return redirect('/');
    
            }
        }

        public function dataPOViewDelete($IdItem){
            if(auth()->check()){
                $dataPODel = DB::table('purchase_order')->where('id', $IdItem)->delete();
                if($dataPODel){
                    return redirect()->back()->with('success','delete data berhasil');
                }else {
                    return redirect()->back()->with('error','delete data gagal');
                }
            }else{
                return redirect('/');
    
            }
        }
        public function dataPOViewEditForm($IdItem){
            if(auth()->check()){
            $dataPOEdit = DB::table('purchase_order')->where('id',$IdItem)->get();
            // dd($dataPOEdit);
            $dataSuppliers = Supplier::pluck('supplier_name');
            $dataSKU= DB::table('items')->pluck('SKU');  
            return view('purchaseOrderEditForm',compact('dataPOEdit','dataSuppliers','dataSKU'));
            }else{
                return redirect('/');
    
            }
        }
    
        public function dataPOEditStatus($IDPO, Request $request){
            try {
            if(auth()->check()){
            $dataPOEditStatus = PO::where('purchase_id', $IDPO)->get();
            if ($dataPOEditStatus->isEmpty()) {
                return redirect()->back()->with('error','data not found');
            }
            $status = $request->validate([
                'POStatus' => 'required'
            ]);
            //edit data sekaligus
            $dataPOEditStatus->each(function ($data) use ($request) {
                $data->update([
                    'PO_status' => $request->POStatus
                ]);
            });
            return redirect()->back()->with('success','edit status berhasil');
        } else {
            return redirect()->back()->with('error','edit status gagal');
    
        }
            }catch (\Exception $e) {
                return response()->json(['error' => $e->getMessage()], 400);
            }
        }
    
            public function dataPOViewEditSave($IdItem, Request $request){
            if(auth()->check()){
            $dataPOToEdit = PO::find($IdItem);
            $file = $request->file('POFileEdit');
            if(!$dataPOToEdit){
                return redirect()->back()->with('error','Data not found');
            }
            $dataPOEditvalid = $request->validate([
                'POCreateDateEdit' => 'required',
                'POInvoiceEdit' => 'required',
                'POSupplierEdit' => 'required',
                'POSKUEdit' => 'required',
                'POQuantityEdit' => 'required',
                'PONotesEdit' => 'nullable',
                'POFileEdit' => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);
            $dataPOEditSave = [
                'create_date' =>$request->POCreateDateEdit,
                'invoice' =>$request->POInvoiceEdit,
                'supplier' =>$request->POSupplierEdit,
                'SKU' =>$request->POSKUEdit,
                'quantity' =>$request->POQuantityEdit,
                'notes' =>$request->PONotesEdit,
            ];
            if ($request->hasFile('POFileEdit') && $file->isValid() && in_array($file->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'webp'])) {
                $fileName = time() . "_edited_".$file->getClientOriginalName() ;
                $folder_upload = 'data_file';
                if ($file->move($folder_upload, $fileName)) {
                    $dataPOEditSave['file'] = $fileName;
                } else {
                    return redirect()->back()->with('error', 'upload file gagal');
                }
            }
            // dd($dataToEdit, $dataPOEditSave);
            if($dataPOToEdit->update($dataPOEditSave)){
                return redirect()->back()->with('success','edit data berhasil');
            }
            return redirect()->back()->with('error','edit status gagal');
            }else{
                return redirect('/');
    
            }
        }
    public function dataPOAddPrice($IDPO, Request $request){
        $dataPrice = $request->validate([
            'PODiscount' => 'nullable',
            'POTax' => 'nullable',
            'POTotalCost' => 'nullable',
        ]);
        // dd($dataPrice);
        $dataPriceUpdate = [
            'discount' => $request->input('PODiscount'),
            'tax' => $request->input('POTax'),
            'total_cost' => $request->input('POTotalCost')
        ];
        // dd($IDPO, $dataPriceUpdate);
        if ($dataPriceUpdate['discount'] || $dataPriceUpdate['tax'] || $dataPriceUpdate['total_cost']) {
            PO::where('purchase_id', $IDPO)->update($dataPriceUpdate); 
            return redirect('purchaseOrder')->with('success', 'Berhasil submit data');
        } else {
            return redirect()->back()->with('error', 'Gagal submit data. Minimal satu data harga harus diisi.');
        }
    }
    
}
