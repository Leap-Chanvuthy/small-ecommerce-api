<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class ProductController extends Controller
{
    //
  public function index(){

    try{
        $product = Product::all()  ;

    return response()->json(["product"=>$product]) ; 
    
} catch(Exception $e){
        return response()->json(["message"=>$e->getMessage()] , 500) ;
    }
   

   

  }

  public function createProduct(Request $request){


    try{
        $request->validate([
            'category_id' => 'required|exists:categories,id',  // this check that categories mean id ot 
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
      ]) ; 
    
      $image_path = null;
    
      if ($request->hasFile('image')) {
          $image = $request->file('image');
          $image_name = time() . '.' . $image->getClientOriginalExtension(); // ke input ey yk ng
          $image_path = $image->storeAs('productImage', $image_name, 'public');
      }
       $product = Product::create([
           'category_id'=>$request->get('category_id') , 
           'name'=>$request->get('name')  , 
           'description'=>$request->get('description') , 
           'price'=>$request->get('price')  , 
           'stock'=>$request->get('stock') , 
           'image' => $image_path , 
    
       ]);
    
       if ($image_path) {
        $product->image = url(Storage::url($image_path));
    }
     
       return response()->json([
        'productdata' => $product,
        'message' => 'Product created successfully'
    ]);
    }catch(Exception $e){
        return response()->json(["message"=>$e->getMessage()] , 500);
    }
     
}






public function updateProduct(Request $request , $id){
try{

    // $product = Product::find($id) ;
    // if(!$product){  

    //     return response()->json(["message"=>"do not have that id in the product"]) ; 

    // }

    // $fill = request()->all() ; 
    // $product->update($fill) ; 

    // return response()->json(["message"=>"update" , 'product' => $product]);


    $product = Product::findOrFail($id);


    $validated = $request -> validate([
        'category_id' => 'required|exists:categories,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|integer|min:0',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // 2MB max
    ]);

    $product -> update ($validated);

    return response() -> json(['message' => 'update success' , 'product' => $product]);
    
}catch (ValidationException $e){
    return response() -> json(['errors' =>  $e -> errors()]);
}
catch(Exception $e){
    

return response()->json(["message"=>$e->getMessage()] , 500) ;
}





}


public function destroy($id){

    $product = Product::findOrFail($id); 
   if(!$product){

    return response()->json(["message"=>"do not have the id that you want to delete"]) ;
   }

    $product->delete() ;
    return response()->json(["message"=>"deleted"])  ;
}
  

  }
   



