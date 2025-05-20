<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreRecipeRequest;
use App\Http\Resources\jsonCustomeResponse;

class RecipeController extends Controller
{

public function index(){
    try{
      $select = DB::SELECT('EXEC [KENTRIES].[showRecipe]');
              return (new jsonCustomeResponse(true,'Recipe Is Available!',$select,201))->response(); 
    }
    catch(\Exception $e){
return (new jsonCustomeResponse(false,'Internal Server Error!',$e->getMessage(),201))->response(); 
    }
}

public function Show($id)
{
    try
    {
$select = DB::SELECT('EXEC [KENTRIES].[GetRecipe] ?',[$id]);
 return (new jsonCustomeResponse(true,'Recipe Is Available!',$select,201))->response(); 
    }
    catch(\Exception $e){
return (new jsonCustomeResponse(false,'Internal Server Error!',$e->getMessage(),201))->response(); 
    }
}

public function Store(StoreRecipeRequest $request)
{
        try {
        DB::statement('EXEC [KENTRIES].[SaveRecipe] ?, ?, ?, ?, ?', [
            $request->name,
            $request->description,
            $request->prep_time,
            $request->cook_time,
            $request->instructions
        ]);
        
        return (new jsonCustomeResponse(true,'Recipe saved successfully!',null,201))->response(); 
    } catch (\Exception $e) {
        return (new jsonCustomeResponse(false,'Failed to save recipe!',$e->getMessage(),500))->response(); 
    }

}


public function update(StoreRecipeRequest $request,$id)
{
        try {
        DB::statement('EXEC [KENTRIES].[UpdateRecipe] ?, ?, ?, ?, ?,?', [
            $id,
            $request->name,
            $request->description,
            $request->prep_time,
            $request->cook_time,
            $request->instructions
        ]);
        return (new jsonCustomeResponse(true,'Recipe Updated successfully!',null,201))->response(); 
    } catch (\Exception $e) {
        return (new jsonCustomeResponse(false,'Failed to Update recipe!',$e->getMessage(),500))->response(); 
    }

}

public function delete($id)
{
  try{
    $select = DB::select('EXEC [KENTRIES].[DeleteRecipe] ?', [$id]);

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
