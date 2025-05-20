<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\OrderItemRequest;
use App\Http\Resources\jsonCustomeResponse;
class orderItemsController extends Controller
{
  public function index(){
    try{
      $select = DB::SELECT('EXEC [KENTRIES].[ShowOrderItems]');
              return (new jsonCustomeResponse(true,'Order Items Is Available!',$select,201))->response(); 
    }
    catch(\Exception $e){
return (new jsonCustomeResponse(false,'Internal Server Error!',$e->getMessage(),201))->response(); 
    }
}

public function Show($id)
{
    try
    {
$select = DB::SELECT('EXEC [KENTRIES].[GetOrderItemByID] ?',[$id]);
 return (new jsonCustomeResponse(true,'Order Item Is Available!',$select,201))->response(); 
    }
    catch(\Exception $e){
return (new jsonCustomeResponse(false,'Internal Server Error!',$e->getMessage(),201))->response(); 
    }
}

public function Store(OrderItemRequest $request)
{
        try {
       foreach ($request->orderItems as $item) {
         DB::statement('EXEC [KENTRIES].[SaveOrderItem] ?, ?,?,?', [
            $item['orderID'],
            $item['foodItemID'],
            $item['quantity'],
            $item['status'],
        ]);
    }
        return (new jsonCustomeResponse(true,'Order Item saved successfully!',null,201))->response(); 
    } catch (\Exception $e) {
        return (new jsonCustomeResponse(false,'Failed to save Item Order!',$e->getMessage(),500))->response(); 
    }

}



public function update(OrderItemRequest $request,$id)
{
        try {
        DB::statement('EXEC [KENTRIES].[UpdateOrder] ?, ?, ?,?,?', [
            $id,
            $request->orderID,
            $request->foodItemID,
            $request->quantity,
            $request->status,
        ]);
        return (new jsonCustomeResponse(true,'Order Item Updated successfully!',null,201))->response(); 
    } catch (\Exception $e) {
        return (new jsonCustomeResponse(false,'Failed to Update Order Item!',$e->getMessage(),500))->response(); 
    }

}

public function delete($id)
{
  try{
    $select = DB::select('EXEC [KENTRIES].[DeleteOrderItem] ?', [$id]);

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
