<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Enums\UserRoleEnum;
use Illuminate\Validation\ValidationException;
use PDO;

class AuthController extends Controller
{
    //
    public function register(Request $request){
       try{
        $request -> validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'phone' => 'string|max:15',
            'address'=>'string|max:15',

        ]) ;  
        
        $user = User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => Hash::make($request->get('password')),
            'phone'=>$request->get('phone'),
            'address'=>$request->get('address'),
            'role' => UserRoleEnum::ADMIN -> value,
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(["user"=>$user , "token"=>$token], 201);
       } catch (ValidationException $e){
        return response() -> json (['errors' => $e -> errors()]);
       }
       catch(Exception $e){
        return response()->json(['error' => $e -> getMessage()]) ; 
       }
 
    }



    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        try {
            //JWTAuth::attempt($credentials) will create the token auto when  $credentials  true ;
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }

           
            $user = auth()->user();

            // (optional) Attach the role to the token.
            $token = JWTAuth::claims(['role' => $user->role])->fromUser($user);

            return response()->json(["token"=>compact('token')]);

        } catch (JWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
        

    }

   

    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(['message' => 'Successfully logged out']);
    }

    

}


