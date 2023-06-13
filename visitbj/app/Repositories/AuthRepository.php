<?php

namespace App\Repositories;
use  App\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\ForgetPassword;
use App\Models\Code;


class AuthRepository implements AuthRepositoryInterface
{
    public function registerUser($userUid,$lastName, $firstName, $email, $password, $phone, $gender,$birthdate){
        try{
            $user = new User();
            $user->first_name = $firstName;
            $user->last_name = $lastName;
            $user->email = $email;
            $user->password = $password;
            $user->phone_number = $phone;
            $user->role = "customer";
            $user->reference = $userUid;
            $user->gender = $gender;
            $user->birthdate = $birthdate;
            $user->save();


            return true;

        }catch(Exception $ex){
            throw new Exception($ex->getMessage());
        }

    }
    //

    public function authenticateUser($login, $password){
        try{

            $foundUser = User::where("email",$login)->first();
            $password = Hash::check($password, $foundUser->password);
             if (!$password) {
                throw new Exception('Votre mot de passe est incorrect');

              }
              else{
                return array(
                    "reference" => $foundUser->reference,
                    "first_name" => $foundUser->first_name,
                    "last_name" => $foundUser->last_name,
                    "email" => $foundUser->email,
                    "gender" => $foundUser->gender,
                    "birthdate" => $foundUser->birthdate,
                    "reference" => $foundUser->reference,
                    "phone" => $foundUser->phone_number
                    ,
                );

              }
        }catch(Exception $ex){
            throw new Exception($ex->getMessage());
        }

    }
    //

    public function send_reset_code($email){
        try{

            $foundUser = User::where("email", $email)->first();
            $ramdomNumber = Str::random(5);

            $foundUser->code_confirmation =  $ramdomNumber;
            $foundUser->is_verified = false;
            $foundUser->save();
            Mail::to($email)->send(new ForgetPassword($ramdomNumber));
            return true;

        }catch(Exception $ex){
            log::error($ex->getMessage());
            throw new Exception($ex->getMessage());
        }
    }

    public function verify_reset_code($code, $email)
    {
        try{

            $foundUser = User::where("email", $email)->where('code_confirmation',$code)->first();
            if(!$foundUser){
                throw new Exception('Code de vérification invalide');
            }

           if($foundUser){
            if($foundUser ->is_verified){
                throw new Exception('Le compte est déjà vérifié');

            }
                $foundUser ->is_verified = true;
                $foundUser ->save();
            return array(
                "first_name" => $foundUser->first_name,
                "last_name" => $foundUser->last_name,
                "email" => $foundUser->email,
                "reference" => $foundUser->reference ,
            );
        }

        }catch(Exception $ex){
            throw new Exception($ex->getMessage());
        }
    }

    public function reset_password($password, $email)
    {
        try{
            $foundUser = User::where("email", $email)->first();
            $foundUser->password = Hash::make($password);
            $foundUser->save();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex->getMessage());
        }
    }

    public function verifyPin($verificationCode){
        try{
              $codeVerify = Code::where("code",$verificationCode)->first();
              if($codeVerify){
                 return true;
              }
              return false;
             }catch( Exception $ex){
                throw new Exception($ex->getMessage());

             }
      }

}

