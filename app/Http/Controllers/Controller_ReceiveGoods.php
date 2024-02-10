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


class Controller_ReceiveGoods extends Controller
{
        //!Route Receive GOODs
        public function receiveGoods(){
            if(auth()->check()){
                $dataIn = DB::table('in')->orderBy('created_at', 'desc')->whereNotIn('placement', ['pending'])->paginate(8);
                return view('receiveGoods',compact('dataIn'));    
            }else{
                return redirect('/');
            }
        }
        public function dataInPost(Request $request){
            if(auth()->check()){
                $dataInvoices = $request->input('addInInvoice');
                $dataIdItemPOs = $request->input('addInIdItemPO');
                $dataIdInbounds = $request->input('addInIdInbound');
                $dataIdPOs = $request->input('addInIdPO');
                $dataSKUs = $request->input('addInSKU');
                $dataNames = $request->input('addInName');
                $dataCategories = $request->input('addInCategories');
                $dataPrices = $request->input('addInPrice');
                $dataQuantities = $request->input('addInQuantity');
                $dataUnits = $request->input('addInUnit');
                $dataNotes = $request->input('addInNotes');
                $dataFiles = $request->file('addInFile'); // Menggunakan file() untuk mengambil file yang diunggah
                $dataPlacements = $request->input('addInPlacement');
                $dataChecks = $request->input('addInCheck');
                $fileName = 'nofile';
                // dd($request);
                if(!$dataFiles){
                    return redirect()->back()->with('error', 'file must be added at least 1');
                }
                foreach ($dataInvoices as $key => $invoice) {
                    $validator = Validator::make($request->all(), [
                        'addInInvoice.' . $key => 'required|string',
                        'addInIdItemPO.' . $key => 'required|string',
                        'addInIdInbound.' . $key => 'required|string',
                        'addInIdPO.' . $key => 'required|string',
                        'addInSKU.' . $key => 'required|string',
                        'addInName.' . $key => 'required|string',
                        'addInCategories.' . $key => 'required|string',
                        'addInPrice.' . $key => 'required|integer',
                        'addInQuantity.' . $key => 'required|integer',
                        'addInUnit.' . $key => 'required|string',
                        'addInNotes.' . $key => 'nullable|string',
                        'addInFile.' . $key => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048',
                        'addInPlacement.' . $key => 'required|string',
                        'addInCheck.' . $key => 'required|in:checked',
                    ]);
                    // dd($validator);
                    if ($validator->fails()) {
                        return redirect()->back()->with('error', 'Make sure all the items are checked and click on the check box');
                        // return redirect()->back()->withErrors($validator)->withInput();
                    }
            $saveDataIn[] =[
                'Id_Inbound' => $dataIdInbounds[$key],
                'id_itemPO' => $dataIdItemPOs[$key],
                'purchase_Id' => $dataIdPOs[$key],
                'invoice' => $dataInvoices[$key],
                'SKU' => $dataSKUs[$key],
                'product_name' => $dataNames[$key],
                'categories' => $dataCategories[$key],
                'price' => $dataPrices[$key],
                'quantity' => $dataQuantities[$key],
                'unit' => $dataUnits[$key],
                'notes' => $dataNotes[$key],
                'file' => $dataFiles[$key] ?? null,
                'placement' => $dataPlacements[$key],
                'checked' => isset($dataChecks[$key]) ? true : false, // Periksa apakah checkbox dicentang
            ];
        }
    
        // dd($saveDataIn, $request->all());
        if ($request->hasFile('addInFile')) {
            foreach ($dataFiles as $key => $file) {
                if ($file->isValid() && in_array($file->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'webp'])) {
                    $fileName = time() . "_" . $file->getClientOriginalName();
                    $folder_upload = 'data_file';
                    if ($file->move($folder_upload, $fileName)) {
                        $saveDataIn[$key]['file'] = $fileName;
                    } else {
                        return redirect()->back()->with('error', 'Save data gagal');
                    }
            }
        }    
            foreach ($saveDataIn as $data) {
                In::create($data);
                if ($data['placement'] !== 'Pending') {
                $increaseItems = Items::where("SKU", $data['SKU'])->first();
                if($increaseItems){
                $increaseItems->quantity += $data['quantity'];
                $increaseItems->save();
                PO::where('id', $data['id_itemPO'])->update(['submited' => 'yes']);
                $cekPending = PO::where('purchase_id', $data['purchase_Id'])->where('submited', 'no')->count();
                if($cekPending == 0){
                    PO::where('purchase_id', $data['purchase_Id'])->update(['PO_status' => 'Received']);
                }else{
                    PO::where('purchase_id', $data['purchase_Id'])->update(['PO_status' => 'Partial Received']); 
                }
                }
                }else{
                    PO::where('purchase_id', $data['purchase_Id'])->update(['PO_status' => 'Partial Received']); 
                // return redirect()->back()->with('error', 'update quantity gagal');
            }
            
            }
            return redirect('receiveGoods')->with('success','berhasil menambahkan stock');
        }    
            }
            return redirect()->back();
        }
    
    
        public function dataInForm(){
            if(auth()->check()){
                $POSelect = DB::table('purchase_order')->select('purchase_id','PO_status')->distinct()->where('PO_status', 'Delivered')->orWhere('PO_status', 'Partial Received')->where('submited', 'no')->get();
                // dd($POSelect);
                return view('receiveGoodsForm',compact('POSelect',));
    
            }else{
                return redirect('/');
            }
        }
    
        public function dataInAddtoTable(Request $request){
            $dataPOCompleted = DB::table('purchase_order')->where('purchase_id',$request['selectID'])->get();
            $IDPO = $request['selectID'];
            $POFile = $dataPOCompleted->where('file','<>',null)->pluck('file')->all();
            $dataSKU = $dataPOCompleted->pluck('SKU');
            $dataItemsPO = DB::table('purchase_order')
            ->join('items', 'purchase_order.SKU', '=', 'items.SKU')
            ->where('purchase_order.purchase_id', $request['selectID'])
            ->select('items.*','purchase_order.id','purchase_order.purchase_id', 'purchase_order.file', 'purchase_order.quantity','purchase_order.supplier','purchase_order.invoice','purchase_order.submited')
            ->get();
            if(!$dataPOCompleted){
                return redirect()->back()->with('error','data not found');
            }else{
                return view('receiveGoodTable',compact('dataItemsPO','IDPO','POFile'));
            }
        }
    
        public function dataInView($IdItem){
            if(!auth()->check()){
                return redirect('/');
            }else{
                //cek status pending dengan menghitung jumlah iditemPO 
                $cekPending = DB::table('in')->where('id', $IdItem)->pluck('id_itemPO');
                $statusPending = DB::table('in')->where('id_itemPO',$cekPending)->count();
                $dataItem = DB::table('in')->where('id', $IdItem)->get();
                // dd($dataItem);

                return view('receiveGoodsView', compact('dataItem','statusPending'));
            }
        }
    
        public function dataInDelete($IdItem, $SKUItem){
            // public function dataInDelete($IdItem, $SKUItem, $IDPO){

            if(!auth()->check()){
                return redirect('/');
            }else{
                $dataInToDelete = In::find($IdItem);
                $qtyToDecease = $dataInToDelete->quantity;
                if($dataInToDelete){
                $decreaseItem = Items::where("SKU", $SKUItem)->first();
                $decreaseItem->quantity -= $qtyToDecease;
                $decreaseItem->save();
                $dataInToDelete->delete();
                // PO::where('purchase_id', $data['purchase_Id'])->update(['deletedFromIn?' => 'yes']); 
                return redirect()->back()->with('succcess','berhasil mengurangi stock');
                }else{
                    return redirect()->back()->with('error','gagal mengurangi stock');

                }
            }
        }

}
