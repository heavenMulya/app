<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Export\userExports;
use Maatwebsite\Excel\Facades\Excel;


class DepartmentsController extends Controller
{



    protected function getAuthToken()
    {
        
        return session('token');
    }
    public function index(){
        //$token=$this->getAuthToken();
        //if(Auth::check()){
        //$response = Http::withHeaders(['Authorization' => 'Bearer ' . $token])->get('http://127.0.0.1:8000/api/product_sp');
        $response = Http::get('http://127.0.0.1:8000/api/products');
        //$employees=[];

        if ($response->successful()) {
            $employees = $response->json(); // Get the JSON data
            return view('index', compact('employees')); // Pass data to the view

        }
        else {
            return redirect()->route('handle_no_data');
        }
    //}
   // else{
    //    return redirect()->route('login');
    //}
     

    }

    public function store(Request $rq){
       //valadate inputs
       $validated_data=$rq->validate([
                 'Department_Brand'=>'required',
                 'Person_Entered'=>'required',
                 'Date_Entered'=>'required',
                 'Month_Entered'=>'required',
                 'Year_Entered'=>'required',
                 'Host_Name'=>'required',
                 'IP_Address'=>'required'
                 ]);

        $Apiurl='http://127.0.0.1:8000/api/store_sp_sp';     //defining url
        
        $response=Http::post($Apiurl,$validated_data);
    if($response->successful()){
        return redirect()->route('get')->with('success', 'Employee added successfully!');
    }    
    else{
        return redirect()->route('get')->with('Error',' adding employee: ' . $response->body());
    }
    
    }


    public function delete($id){
        $Apiurl='http://127.0.0.1:8000/api/delete_products/' .$id;

        $response=Http::delete($Apiurl);

        if($response->successful()){
            return redirect()->route('get')->with('success', 'Employee deleted successfully!');
        }    
        else{
            return redirect()->back()->with('no','deleting employee: ' . $response->body());
        }


    }

    public function handler(Request $rq){
        //$token=$rq->session()->get('token');
        //$token=$this->getAuthToken();
        return view('handler');
    }


    public function update(Request $rq,$id){
        //validating data
        $validated_data=$rq->validate([
                  'Department_Brand'=>'required',
                  'Person_Entered'=>'required',
                 'Date_Entered'=>'required',
                 'Month_Entered'=>'required',
                 'Year_Entered'=>'required',
                 'Host_Name'=>'required',
                 'IP_Address'=>'required'
        ]);

        $Apiurl='http://127.0.0.1:8000/api/update_products/' .$id;
        $response=Http::put($Apiurl,[
            'Department_Brand'=> $validated_data['Department_Brand'],
            'Person_Entered'=> $validated_data['Person_Entered'],
            'Date_Entered'=> $validated_data['Date_Entered'],
            'Month_Entered'=> $validated_data['Month_Entered'] ,
            'Year_Entered'=> $validated_data['Year_Entered'],
            'Host_Name'=> $validated_data['Host_Name'],
            'IP_Address'=>$validated_data['IP_Address'] 
        ]
        );

        if($response->successful()){
            return redirect()->route('get')->with('success', 'Employee updated successfully!');
        }    
        else{
            return redirect()->back()->with('no','updating employee: ' . $response->body());
        }


    }

   
}
