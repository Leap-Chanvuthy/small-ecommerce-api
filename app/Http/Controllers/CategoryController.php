<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
public function index(){
 

    try{
        $product = Category::all() ; 


        return response()->json(["message"=>$product])  ;
    }
    catch(Exception $e){
        return response()->json(["message"=>$e->getMessage()])  ; 
    }



}


 public function create(Request $request){

      
   try{

    $request->validate([
        'name' => 'required|string|max:255', // Validate name
        'description' => 'nullable|string|max:500', // Validate description (nullable)
    ]) ; 

    $category = Category::create([

          'name'=>$request->get('name')  , 
          'description'=>$request->get('description')  ,  
    ]);
        return response()->json(["category"=>$category]) ; 
   
 }

 catch(Exception $e){
    return response()->json(["message"=>$e->getMessage() , 500]) ;
 }
}



public function update(Request $request){

}


}
