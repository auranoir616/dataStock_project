<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Shipping;

use Illuminate\Http\Request;
use App\Http\Requests\Req_SH;
use Illuminate\Support\Facades\DB;

class Controller_Shipping extends Controller
{
    public function dataShippingForm($IDSH){
        if(auth()->check()){
            $dataShipping = DB::table('shipping')->where('shipping_id', $IDSH)->get();
        return view('shippingForm',compact('dataShipping'));
        }else{
            return redirect('/');
        }
    }
public function addDataShipping(Req_SH $request){
        if (!auth()->check()) {
            return view('loginpage');
        }else{
        $dataShipping = $request->validated();
        $file = $request->file('SHFile');
        $saveDataShipping = [
            'shipping_id' => $dataShipping['SHShipping_id'],
            'receipt' => $dataShipping['SHReceipt'],
            'destination' => $dataShipping['SHDestination'],
            'name' => $dataShipping['SHName'],
            'expedition' => $dataShipping['SHExpedition'],
            'shipping_cost' => $dataShipping['SHShippingCost'],
            'file' => $request['SHFile'] ?? null,
            'SKU'=> $dataShipping['SHSKU'],
            'price'=> $dataShipping['SHPrice'],
            'product'=> $dataShipping['SHProduct'],
            'quantity'=> $dataShipping['SHQuantity'],
            'discount'=> $dataShipping['SHDiscount'],
            'notes' =>$dataShipping['SHNotes']
            // 'total_cost'=> $dataShipping['SHTotal_cost'],
            // 'tax'=> $dataShipping['SHTax'],

        ];
        // dd($dataPO, $saveDataPO );
        if ($request->hasFile('SHFile') && $file->isValid() && in_array($file->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'webp'])) {
            $fileName = time() . "_" . $request['SHShipping_id'] .$file->getClientOriginalName() ;
            $folder_upload = 'data_file';
            if ($file->move($folder_upload, $fileName)) {
                $saveDataShipping['file'] = $fileName;
            } else {
                return redirect()->back()->with('error', 'save data gagal');
            }
        }
        if (Shipping::create($saveDataShipping)) {
            $decreaseItems = Items::where("SKU", $saveDataShipping['SKU'])->first();
            if($decreaseItems){
            $decreaseItems->quantity -= $saveDataShipping['quantity'];
            $decreaseItems->save();
            }
            return redirect()->back()->with('success', 'save data berhasil');
        }
        return redirect()->back()->with('error', 'upload data gagal');
    }
}
    public function dataShipping(){
        if(!auth()->check()){
            return redirect('/');
        }else{
            $dataSHIds = DB::table('shipping')->select('shipping_id')->distinct()->get();
            $dataSH = collect();
            foreach ($dataSHIds as $row) {
            $shippingId = $row->shipping_id;
            $dataUnique = DB::table('shipping')->where('shipping_id', $shippingId)->first();
            if($dataUnique){
            $dataSH->push($dataUnique);
            }
        }
        $dataSHQuery = DB::table('shipping')->whereIn('id', $dataSH->pluck('id'));
        $dataSH = $dataSHQuery->orderBy('created_at','desc')->paginate(7);

            return view('shipping', ['shipping' => $dataSH]);
        }
    }

    public function dataShippingTableDelete($IdItem, $SKUItem){
        if(auth()->check()){
            $dataShipToDelete = shipping::find($IdItem);
            $qtyToIncrease = $dataShipToDelete->quantity;
            if($dataShipToDelete){
            $increaseItem = Items::where("SKU", $SKUItem)->first();
            $increaseItem->quantity += $qtyToIncrease;
            $increaseItem->save();
            $dataShipToDelete->delete();
            if($dataShipToDelete){
                return redirect()->back()->with('success','delete data berhasil');
            }else {
                return redirect()->back()->with('error','delete data gagal');
            }
        }else{
            return redirect('/');

        }
    }

    }

    public function dataShippingSubmit($IDSH, Request $request){
        $dataShippingCost = $request->validate([
            'SHTotal_cost' => 'nullable',
            'SHTax' => 'nullable',
        ]);
        // dd($dataPrice);
        $dataShippingUpdate = [
            'tax' => $request->input('SHTax'),
            'total_cost' => $request->input('SHTotal_cost')
        ];
        // dd($IDPO, $dataPriceUpdate);
        if ($dataShippingUpdate['tax'] || $dataShippingUpdate['total_cost']) {
            Shipping::where('shipping_id', $IDSH)->update($dataShippingUpdate); 
            return redirect('shipping')->with('success', 'Berhasil submit data');
        } else {
            return redirect()->back()->with('error', 'Gagal submit data. Minimal satu data harga harus diisi.');
        }
    }

    public function dataShippingStatus($IDSH, Request $request){
        try {
        if(auth()->check()){
        $dataSHToEdit = Shipping::where('shipping_id', $IDSH)->get();
        if ($dataSHToEdit->isEmpty()) {
            return redirect()->back()->with('error','data not found');
        }
        $status = $request->validate([
            'SHStatus' => 'required'
        ]);
        //edit data sekaligus
        $dataSHToEdit->each(function ($data) use ($request) {
            $data->update([
                'status' => $request->SHStatus
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

    public function dataShippingView($IDSH){
        if(!auth()->check()){
            return redirect('/');
        }else{
            $shippingView = DB::table('shipping')->where('shipping_id', $IDSH)->get();
            return view('shippingView',compact('shippingView','IDSH'));
    }
    }
    }


