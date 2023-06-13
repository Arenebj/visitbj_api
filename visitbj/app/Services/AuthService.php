<?php

namespace App\Services;
use Exception;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthService
{
    protected AuthRepository $_authRepository;
    public function __construct(AuthRepository $authRepository)
    {
       $this->_authRepository = $authRepository;
    }

     //register user
     public function registerUser($lastName, $firstName, $email, $password, $phone, $gender ,$birthday){

         try {
         //check on gender
         $gender = strtoupper(trim($gender));

         //check on phone number
         //TODO: integrer le + au debut de chaque numero
         if(isset($phoneNumber) ){
            $phoneNumber = strtoupper(trim($phoneNumber));

            if (!preg_match('/[0-9]{2}/', $phoneNumber)) {
                throw new Exception("Veuillez entrer un numéro de téléphone valide.");
            }
         }

         //hash password
         $password = Hash::make($password);
         $userUid =  (string) Str::orderedUuid();

         //register user
         $creationResult = $this->_authRepository->registerUser($userUid,$lastName, $firstName, $email, $password, $phone, $gender, $birthday);

         return $creationResult;

         } catch (\Exception $th) {
             throw $th;
         }

 }

 public function authenticateUser($login, $password){
    try{
        return $this->_authRepository->authenticateUser($login, $password);

    } catch (Exception $th) {
        throw $th;
    }

}//end authenticateUser


public function send_reset_code($email){
    try{
        return $this->_authRepository->send_reset_code($email);
    }catch(Exception $ex){
       throw new Exception($ex);
    }
}


public function verify_reset_code($code, $email){
    try{
        return $this->_authRepository->verify_reset_code($code, $email);
    }catch(Exception $ex){
       throw new Exception($ex);
    }

}


public function reset_password($password, $email){
    try{
        return $this->_authRepository->reset_password($password, $email);
    }catch(Exception $ex){
        throw new Exception($ex);
    }
}


  //
}




