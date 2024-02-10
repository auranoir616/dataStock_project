<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Broken;
use App\Models\ReturnIn;
use Illuminate\Http\Request;
use App\Http\Requests\Req_Broken;
use Illuminate\Support\Facades\DB;

class Controller_Broken extends Controller
{
    public function dataBrokenStock(){
        if(!auth()->check()){
            return redirect('/');
        }else{
            $dataBroken = DB::table('brokenstock')->paginate(7);
            return view('brokenStockHistory',compact('dataBroken'));
        }
    }

    public function dataBrokenSelect(){
        if(!auth()->check()){
            return redirect('/');
        }else{
            $dataBrokenReturn = ReturnIn::where('submited', 'Broken')->get();
            return view('brokenStockSelect',compact('dataBrokenReturn'));
        }

    }

    public function dataBrokenView($IDBR){
        if(!auth()->check()){
            return redirect('/');
        }else{
            $dataBrokenView = DB::table('brokenstock')->where('broken_id', $IDBR)->get();
            return view('brokenStockView',compact('dataBrokenView'));
        }

    }

    public function dataBrokenAddFromReturn($IDRE, $SKU){
        if(!auth()->check()){
            return redirect('/');
        }else{
            $dataFromReturn = DB::table('returnin')->where('return_id', $IDRE)->where('SKU', $SKU)->get();
            // dd($dataFromReturn);
            return view('brokenStock',compact('dataFromReturn'));
        }

    }
    public function dataBrokenNew(Req_Broken $request)
    {
        if (!auth()->check()) {
            return view('loginpage');
        } else {
            $dataBroken = $request->validated();
            $file = $request->file('brokenFile');
    
            if ($request->hasFile('brokenFile') && $file->isValid() && in_array($file->getClientOriginalExtension(), ['jpeg', 'png', 'jpg', 'gif', 'webp'])) {
                $fileName = time() . "_broken_" . $file->getClientOriginalName();
                $folder_upload = 'data_file';
                // Pindahkan file setelah kondisi terpenuhi
                if ($file->move($folder_upload, $fileName)) {
                    $dataBroken['brokenFile'] = $fileName;
                    $saveDataBroken = Broken::create([
                        'broken_id' => $dataBroken['brokenID'],
                        'SKU' => $dataBroken['brokenSKU'],
                        'product' => $dataBroken['brokenProduct'],
                        'quantity' => $dataBroken['brokenQuantity'],
                        'notes' => $dataBroken['brokenNotes'],
                        'reference' => $dataBroken['brokenReference'],
                        'file' => $fileName,
                    ]);
                    if($saveDataBroken){
                        $decreaseItems = Items::where("SKU", $saveDataBroken['SKU'])->first();
                        if($decreaseItems){
                        $decreaseItems->quantity -= $saveDataBroken['quantity'];
                        $decreaseItems->save();
                        }
                        $setStatusReturn = ReturnIn::where('return_id', $saveDataBroken['reference'])->where('SKU', $saveDataBroken['SKU'])->first();
                        if($setStatusReturn){
                        $setStatusReturn->update(['submited' => 'submited broken']); 
                       }
                    return redirect('broken-history')->with('success', 'Add Broken Stock Success');
                } else {
                    return redirect()->back()->with('error', 'Add Broken Stock Failed');
                }
            } else {
                return redirect()->back()->with('error', 'Invalid file format');
            }
        }
    }
    
}
}
