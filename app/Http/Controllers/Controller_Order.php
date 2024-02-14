<?php

namespace App\Http\Controllers;

use App\Models\Items;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Requests\Req_Order;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class Controller_Order extends Controller
{


// public function formatTimeAgo($updatedAt){
//     $updatedTime = Carbon::parse($updatedAt);
//     $now = Carbon::now();

//     if ($updatedTime->diffInDays($now) > 0) {
//         return $updatedTime->diffInDays($now) . ' days ago';
//     } elseif ($updatedTime->diffInHours($now) > 0) {
//         return $updatedTime->diffInHours($now) . ' hours ago';
//     } elseif ($updatedTime->diffInMinutes($now) > 0) {
//         return $updatedTime->diffInMinutes($now) . ' minutes ago';
//     } else {
//         return 'Just now';
//     }
// }

    public  function SuggestionSKU(Request $request){
        $query = $request->input('query');
        $suggestions = Items::where('SKU','like',"%$query%")->limit(5)->pluck('SKU');
        return response()->json(['suggestions' => $suggestions]);
    }

    public function GetItem($product){
        $dataItem = Items::where('SKU', $product)->first();
        return response()->json(['item' => $dataItem]);
    }
// ! 
    public function dataOrder($ORID){
        $getDataOrder = Order::where('order_id', $ORID)->get();
        return view('order', compact('getDataOrder'));

    }
    public function AddPriceTax($ORID, Request $request){
        if(!auth()->check()){
            return redirect('/');
        }else{
            // $orderDatas = Order::where('order_id', $ORID)->get();
            $priceTax = $request->validate([
                'ORCash' => 'required',
                'ORTax' => 'required',
            ]);
            Order::where('order_id', $ORID)->update([
                'cash' => $request->ORCash,
                'tax' => $request->ORTax
            ]);            // dd($orderDatas, $request);
            return redirect()->back()->with('success','Order successfuly saved');
        }
    }
    public function AddOrder(Req_order $request){
        if(!auth()->check()){
            return redirect('/');
        }else{
            $dataOrder = $request->validated();
            $dataOrderSave = [
                'order_id' => $dataOrder['ORID'],
                'SKU' => $dataOrder['ORSKU'],
                'product' => $dataOrder['ORProduct'],
                'price' => $dataOrder['ORPrice'],
                'quantity' => $dataOrder['ORQuantity'],
                'discount' => $dataOrder['ORDiscount'],
                'subtotal' => $dataOrder['ORSubtotal']
            ];

            if(Order::create($dataOrderSave)){
                $decreaseItems = Items::where("SKU", $dataOrderSave['SKU'])->first();
                if($decreaseItems){
                $decreaseItems->quantity -= $dataOrderSave['quantity'];
                $decreaseItems->save();
            };
            return redirect()->back()->with('success', 'Save data order sukses');

        }


    } 
}
public function dataOrderView($ORID){
    $DataOrderDetail = Order::where('order_id', $ORID)->get();
    return view('orderView', compact('DataOrderDetail'));

}


public function dataOrderHistory(){
    if(!auth()->check()){
        return redirect('/');
    }else{
        $dataOrders = DB::table('order')->select('order_id')->distinct()->get();
        $dataIdOrder = collect();
        foreach ($dataOrders as $row) {
            $orderId = $row->order_id;
            $dataUnique = DB::table('order')->where('order_id', $orderId)->first();
            if($dataUnique){
            $dataIdOrder->push($dataUnique);
            }
        }
        $dataOrderQuery = DB::table('order')->whereIn('id', $dataIdOrder->pluck('id'));
        $dataOrder = $dataOrderQuery->orderBy('created_at','desc')->paginate(7);
        //format waktu sebelum ditampilkan
        // foreach ($dataOrder as $order) {
        //     $order->formatted_updated_at = $this->formatTimeAgo($order->updated_at);
        // }
        
            return view('orderHistory',compact('dataOrder'));   
    }
}


public function dataOrderTableDelete($IdItem, $SKUItem){
    if(!auth()->check()){
        return redirect('/');
    }else{
        $dataInToDelete = Order::find($IdItem);
        $qtyToIncrease = $dataInToDelete->quantity;
        if($dataInToDelete){
        $IncreaseItem = Items::where("SKU", $SKUItem)->first();
        $IncreaseItem->quantity += $qtyToIncrease;
        $IncreaseItem->save();
        $dataInToDelete->delete();
        return redirect()->back()->with('succcess','delete data success');
        }else{
            return redirect()->back()->with('error','gagal mengurangi stock');

        }
    }

}
}