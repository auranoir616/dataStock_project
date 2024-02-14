<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\ReturnIn;
use App\Models\Shipping;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class Controller_Return extends Controller
{
    public function dataReturn(){
        if(!auth()->check()){
            return redirect('/');
        }else{
            $dataREIds = DB::table('returnin')->where('submited','<>','no')->distinct()->get();
            $dataReturn = collect();
            foreach ($dataREIds as $row) {
            $returnId = $row->return_id;
            $dataUnique = DB::table('returnin')->where('return_id', $returnId)->where('submited','<>','no')->first();
            if($dataUnique){
            $dataReturn->push($dataUnique);
            }
        }
        $dataREQuery = DB::table('returnin')->whereIn('id', $dataReturn->pluck('id'));
        $dataReturn = $dataREQuery->orderBy('created_at','desc')->paginate(7);
        return view('return', compact('dataReturn'));
    }
}
        public function dataReturnReceive($IDSH){
            if(!auth()->check()){
                return redirect('/');
            }else{
                $dataToReceive = DB::table('shipping')->where('shipping_id', $IDSH)->get();
                return view('returnReceive', compact('dataToReceive','IDSH'));
        }
            }
            public function dataReturnForm(){
                if(auth()->check()){
                    $ShippingIDSelect = DB::table('shipping')->select('shipping_id','status')->distinct()
                    ->where(function($query) {$query->where('status', 'Returned')->orWhere('status', 'Cancel');})->where('submited_in', 'no')->get();
                    return view('returnForm',compact('ShippingIDSelect',));

                }else{
                    return redirect('/');
                }
            }


    public function dataReturnView($IDRE){
        if(!auth()->check()){
            return redirect('/');
        }else{
            $dataReturnID = DB::table('returnin')->where('return_id', $IDRE)->first();
            $IDSH = $dataReturnID->shipping_id;
            $statusShipping = DB::table('shipping')->select('status')->where('shipping_id', $IDSH)->first();
            // dd($statusShipping);
            $dataReturn = DB::table('returnin')->where('return_id', $IDRE)->get();
            return view('returnView',compact('dataReturn','IDRE','statusShipping'));

        }
        
    }

    public function dataReturnPost(Request $request){
        if(auth()->check()){
        $dataReceipts = $request->input('addReturnReceipt');
        $dataIdReturns = $request->input('addReturnId');
        $dataIdSHs = $request->input('addReturnShippingId');
        $dataSKUs = $request->input('addReturnSKU');
        $dataExpeditions = $request->input('addReturnExpedition');
        $dataProducts = $request->input('addReturnProduct');
        $dataDatesents = $request->input('addReturnDateSent');
        $dataQuantities = $request->input('addReturnQuantity');
        $dataNotes = $request->input('addReturnNotes');
        $dataFiles = $request->file('addReturnFile'); // Menggunakan file() untuk mengambil file yang diunggah
        $dataPlacements = $request->input('addReturnPlacement');
        $dataChecks = $request->input('addReturnCheck');
        $fileName = 'nofile';
        // dd($request);
        if(!$dataFiles){
            return redirect()->back()->with('error', 'file must be added at least 1');
        }
        foreach ($dataReceipts as $key => $receipt) {
            $validator = Validator::make($request->all(), [
                'addReturnReceipt.' . $key => 'required|string',
                'addReturnId.' . $key => 'required|string',
                'addReturnShippingId.' . $key => 'required|string',
                'addReturnSKU.' . $key => 'required|string',
                'addReturnExpedition.' . $key => 'required|string',
                'addReturnProduct.' . $key => 'required|string',
                'addReturnDateSent.' . $key => 'required|string',
                'addReturnQuantity.' . $key => 'required|integer',
                'addReturnNotes.' . $key => 'nullable|string',
                'addReturnFile.' . $key => 'nullable|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'addReturnPlacement.' . $key => 'required|string',
                'addReturnCheck.' . $key => 'required|in:checked',
            ]);
            // dd($validator , $request);
            if ($validator->fails()) {
                return redirect()->back()->with('error', 'Make sure all the items are checked and click on the check box');
                // return redirect()->back()->withErrors($validator)->withInput();
            }
    $saveDataReturn[] =[
        'return_id' => $dataIdReturns[$key],
        'shipping_id' => $dataIdSHs[$key],
        'receipt' => $dataReceipts[$key],
        'SKU' => $dataSKUs[$key],
        'product' => $dataProducts[$key],
        'quantity' => $dataQuantities[$key],
        'expedition' => $dataExpeditions[$key],
        'date_sent' => $dataDatesents[$key],
        'notes' => $dataNotes[$key],
        'files' => $dataFiles[$key] ?? null,
        'placement' => $dataPlacements[$key],
        'check' => isset($dataChecks[$key]) ? true : false, // Periksa apakah checkbox dicentang
    ];
}

// dd($saveDataIn, $request->all());
if ($request->hasFile('addReturnFile')) {
    foreach ($dataFiles as $key => $file) {
        if ($file->isValid() && in_array($file->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'webp'])) {
            $fileName = time() . "_" . $file->getClientOriginalName();
            $folder_upload = 'data_file';
            if ($file->move($folder_upload, $fileName)) {
                $saveDataReturn[$key]['files'] = $fileName;
            } else {
                return redirect()->back()->with('error', 'Save data gagal');
            }
    }
}    
    foreach ($saveDataReturn as $data) {

        // dd($data['return_id'],$data['SKU'] );
        ReturnIn::create($data);
        if ($data['placement'] !== 'Broken') {
        $increaseItems = Items::where("SKU", $data['SKU'])->first();
        if($increaseItems){
        $increaseItems->quantity += $data['quantity'];
        $increaseItems->save();
        ReturnIn::where('SKU', $data['SKU'])->update(['submited' => 'yes']); 
        }
        // dd($increaseItems);
        // return redirect()->back()->with('error', 'update quantity gagal');
    }else{
        //! sebab
        ReturnIn::where('return_id', $data['return_id'])->where('SKU', $data['SKU'])->update(['submited' => 'Broken']);
        $increaseItems = Items::where("SKU", $data['SKU'])->first();
        if($increaseItems){
            $increaseItems->quantity += $data['quantity'];
            $increaseItems->save();
        }    
    }
    Shipping::where('shipping_id', $data['shipping_id'])->update(['submited_in' => 'yes']);


    }
    return redirect('return')->with('success','berhasil menambahkan stock');
}    
    }
    return redirect()->back();
}


}