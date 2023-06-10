<?php

namespace App\Repositories;
use  App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;



class AuthRepository implements AuthRepositoryInterface
{
    public function registerUser($userUid,$lastName, $firstName, $email, $password, $phone){
        try{
            $user = new User();
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->email = $email;
            $user->password = $password;
            $user->phone_number = $phone;
            $user->role = "customer";
            $user->reference = $userUid;
            $user->save();


            return true;

        }catch(Exception $ex){
            throw  new Exception($ex);
        }

    }
    //

    public function authenticateUser($login, $password){
        try{

            Log::error($login);
            Log::error($password);
            $foundUser = User::where("email",$login)->first();
            $password = Hash::check($password, $foundUser->password);
             if (!$password) {
                throw new Exception('Votre email ou votre mot de passe est incorrect');

              }
              else{
                return array(
                    "first_name" => $foundUser->first_name,
                    "last_name" => $foundUser->last_name,
                    "email" => $foundUser->email,
                    "reference" => $foundUser->reference ,
                );

              }


        }catch(Exception $ex){
            throw  new Exception($ex);
        }

    }
    //

}
