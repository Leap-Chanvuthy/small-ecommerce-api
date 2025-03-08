<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    public function getUser()
    {
        try {
            $users = User::paginate(10);
            return response() -> json (['users' => $users ]);
        }catch (Exception $e){
            return response() -> json (['error' => $e -> getMessage()]);
        }
    } 
     
    public function update(Request $request, $id)
    {
       
        $user = User::find($id);
    
        if (!$user) {
            return response()->json(["message" => "User not found"], 404);
        }
    
    
        $user->update($request->all());
    
        return response()->json(["message" => "User updated successfully", "user" => $user], 200);
    }
    


    public function destroy($id){

      try{
        $user = User::find($id)  ; 
        if(!$user){
            return response()->json(["message"=>"user not found"]);
        }

        $user->delete()  ;
        return response()->json(["message"=>"deleted"])  ;

      }
      catch(Exception $e){

        return response()->json(['message' => $e->getMessage()], 401);

      }
    }
}
