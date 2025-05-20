<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\FoodItemsRequest;
use App\Http\Resources\jsonCustomeResponse;

class foodItemsController extends Controller
{
    public function index(){
    try{
      $select = DB::SELECT('EXEC [KENTRIES].[GetFoodItems]');
              return (new jsonCustomeResponse(true,'Food Items Is Available!',$select,201))->response(); 
    }
    catch(\Exception $e){
return (new jsonCustomeResponse(false,'Internal Server Error!',$e->getMessage(),201))->response(); 
    }
}

public function Show($id)
{
    try
    {
$select = DB::SELECT('EXEC [KENTRIES].[GetFoodItemByID] ?',[$id]);
 return (new jsonCustomeResponse(true,'Food Items Is Available!',$select,201))->response(); 
    }
    catch(\Exception $e){
return (new jsonCustomeResponse(false,'Internal Server Error!',$e->getMessage(),201))->response(); 
    }
}

public function Store(FoodItemsRequest $request)
{
        try {
        DB::statement('EXEC [KENTRIES].[SaveFoodItem] ?, ?, ?, ?, ?,?', [
            $request->name,
            $request->recipeID,
            $request->price,
            $request->category,
            $request->stockQuantity,
            $request->ImageURL
        ]);
        
        return (new jsonCustomeResponse(true,'Food Items saved successfully!',null,201))->response(); 
    } catch (\Exception $e) {
        return (new jsonCustomeResponse(false,'Failed to save Food Items!',$e->getMessage(),500))->response(); 
    }

}


public function update(FoodItemsRequest $request,$id)
{
        try {
        DB::statement('EXEC [KENTRIES].[UpdateFoodItem] ?, ?, ?, ?, ?,?,?', [
            $id,
            $request->name,
            $request->recipeID,
            $request->price,
            $request->category,
            $request->stockQuantity,
             $request->ImageURL
        ]);
        return (new jsonCustomeResponse(true,'Food Items Updated successfully!',null,201))->response(); 
    } catch (\Exception $e) {
        return (new jsonCustomeResponse(false,'Failed to Update Food Items!',$e->getMessage(),500))->response(); 
    }

}

public function delete($id)
{
  try{
    $select = DB::select('EXEC [KENTRIES].[DeleteFoodItem] ?', [$id]);

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
