<?php

namespace App\Http\Controllers\AuthNew;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\loginRequest;
use App\Http\Resources\jsonCustomeResponse;

class loginCheckController extends Controller
{
    
    public function login(loginRequest $request)
    {
        try{
        $result = DB::select('exec KMASTER.UserLogin ?,?',[$request->username,$request->password]);

        if(!empty($result)){
        $status = $result[0]->Status ?? 'ERROR';
        $message = $result[0]->Message ??'Unkown Error';
       // print_r($status);
        return (new jsonCustomeResponse($status === 'SUCCESS', $message, null, $status === 'SUCCESS' ? 200 : 404))->response();
        }
        else{
     return (new jsonCustomeResponse(false, 'No response from procedure', null, 500))->response();
        }
    }
    catch(\Exception $e)
    {
       return (new jsonCustomeResponse(false,'Internal Server Error',$e->getMessage(),500))->response();  
    }
    }
}
