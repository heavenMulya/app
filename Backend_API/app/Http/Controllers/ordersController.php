<?php

namespace App\Http\Controllers;
use App\Events\NewOrderEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderRequest;
use App\Http\Resources\jsonCustomeResponse;

class ordersController extends Controller
{

 public function getOrders()
{
     $orders = DB::select('EXEC GetNewOrders');
    return response()->json($orders);
}

 public function index(){
    try{
      $select = DB::SELECT('EXEC [KENTRIES].[ShowOrders]');
              return (new jsonCustomeResponse(true,'Order Is Available!',$select,201))->response(); 
    }
    catch(\Exception $e){
return (new jsonCustomeResponse(false,'Internal Server Error!',$e->getMessage(),201))->response(); 
    }
}

public function Show($id)
{
    try
    {
$select = DB::SELECT('EXEC [KENTRIES].[GetOrderByID] ?',[$id]);
 return (new jsonCustomeResponse(true,'Order Is Available!',$select,201))->response(); 
    }
    catch(\Exception $e){
return (new jsonCustomeResponse(false,'Internal Server Error!',$e->getMessage(),201))->response(); 
    }
}

public function Store(OrderRequest $request)
{
        try {
       $order = DB::select('EXEC [KENTRIES].[SaveOrder] ?, ?,?,?', [
            $request->customerName,
            $request->orderStatus,
            $request->CustomerPhone,
            $request->TableName,
        ]);
       
         broadcast(new OrderCreated($order));
if (!empty($order)) {
    $status = $order[0]->Status ?? 'ERROR';
    $message = $order[0]->Message ?? 'Unknown Error';
     $orderID = $order[0]->OrderID ?? 1;
    // Return JSON response based on status
return (new jsonCustomeResponse($status === 'SUCCESS', $message, $orderID, $status === 'SUCCESS' ? 200 : 404))->response();
        
 } //return (new jsonCustomeResponse(true,'Order saved successfully!',null,201))->response(); 
    } catch (\Exception $e) {
        return (new jsonCustomeResponse(false,'Failed to save Order!',$e->getMessage(),500))->response(); 
    }

}


public function update(OrderRequest $request,$id)
{
        try {
        DB::statement('EXEC [KENTRIES].[UpdateOrder] ?, ?, ?,?,?', [
            $id,
            $request->customerName,
            $request->orderStatus,
            $request->CustomerPhone,
            $request->TableName,
        ]);
        return (new jsonCustomeResponse(true,'Order Updated successfully!',null,201))->response(); 
    } catch (\Exception $e) {
        return (new jsonCustomeResponse(false,'Failed to Update Order!',$e->getMessage(),500))->response(); 
    }

}

public function updateOrderStatus(Request $request,$id)
{
       $data = $request->validate([
        'orderStatus'=>'Required|string',
       ]);
        try {
        DB::statement('EXEC [KENTRIES].[UpdateOrderStatus] ?, ?', [
            $id,
            $request->orderStatus,
        ]);
        return (new jsonCustomeResponse(true,'Order Status Updated successfully!',null,201))->response(); 
    } catch (\Exception $e) {
        return (new jsonCustomeResponse(false,'Failed to Update Order Status!',$e->getMessage(),500))->response(); 
    }

}

public function delete($id)
{
  try{
    $select = DB::select('EXEC [KENTRIES].[DeleteOrder] ?', [$id]);

if (!empty($select)) {
    $status = $select[0]->Status ?? 'ERROR';
    $message = $select[0]->Message ?? 'Unknown Error';

    // Return JSON response based on status
    return (new jsonCustomeResponse($status === 'SUCCESS', $message, null, $status === 'SUCCESS' ? 200 : 404))->response();
} else {
    return (new jsonCustomeResponse(false, 'No response from procedure', null, 500))->response();
}

  }
 catch (\Exception $e) {
        return (new jsonCustomeResponse(false,'Internal Server Error',$e->getMessage(),500))->response(); 
    }
}

}
