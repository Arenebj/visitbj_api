<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected AuthService $_authService;
    public function __construct(AuthService $authService)
    {
        $this->_authService = $authService;
    }

    public function registerUser(Request $request){
        try {
           $rData = array(
            "last_name" => $request->get("last_name"),
            "first_name" => $request->get("first_name"),
            "password" => $request->get("password"),
            "phone" => $request->get("phone"),
            "email" => $request->get("email"),

            );

            $validator = [
                'last_name' => ['required'],
                'first_name' => ['required'],
                'email' => ['required','email','unique:users,email'],
                'phone' => ['required', 'unique:users,phone_number' ],
                'password' => ['required'],

            ];
            $validationMessages = ['last_name.required' => 'Le prénom est requis', 'first_name.required' => 'Le nom de famille est requis',
            'adresse.unique' => 'Cet numéro de téléphone est déja utilisé','email.required' => "L'adresse email est requis",
             'password.required' => 'Le mot de passe est requis','email.email' => 'Veuillez fournir une adresse email valide',
             'email.unique' => 'Cette adresse email est déja utilisée','phone.unique' => "Ce numéro de téléphone est déjà utilisé." ,
            ];

            $validatorResult = Validator::make($rData, $validator, $validationMessages); //
            if ($validatorResult->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validatorResult->errors()->first(), //
                ], 400);
            }

            //get data as variables
            $lastName = $rData["last_name"];
            $firstName = $rData["first_name"];
            $email = $rData["email"];
            $password= $rData["password"];
            $phone= $rData["phone"];


            //do operation
            $resultRegister = $this->_authService->registerUser($lastName, $firstName, $email, $password, $phone);

            if($resultRegister === true){
                return response()->json([
                    'success' =>  true,
                    'message' => "Le compte a été créé avec succès",
                ], 201);
            }


        } catch (Exception $ex) {
            log::error($ex->getMessage());
            //error result
            return response()->json([
                'success' => false,
                'message' =>"Une erreur est survenue pendant l'inscription. Veuillez réessayer",
            ], 400);
        }

    }



     //authentication method
     public function authenticateUser(Request $request)
     {
         try {

             //request data
             $rData =  $request->only(["email", "password"]);

           //validator
           $validatorRules  = [
             'email' => ['required',"exists:users,email"],
             'password' => 'required'
           ];

             $validationMessages = [
                 'email.required' => "L'adresse email est requise",
                 'email.exists' => "L'adresse email n'est pas valide",
                 'password.required' => 'Le mot de passe est requis'
             ];

             $validatorResult = Validator::make($rData, $validatorRules, $validationMessages);
             if ($validatorResult->fails()) {
                 return response()->json([
                   'success' => false,
                   'message' => $validatorResult->errors()->first(), //
                 ], 400);
             }

             //get data
             $email = $rData ["email"] ;
             $password = $rData ["password"];

             //call service
               $resultRegisterOperation = $this->_authService->authenticateUser($email,$password);
               return response()->json([
                'data' =>$resultRegisterOperation,
                'message' => "Vous êtes bien connecté.",
            ], 200);
         }catch (Exception $ex) {
             //error result
             log::error($ex);
             return response()->json([
                 'success' => false,
                 'message' =>"Une erreur est survenue pendant la connexion. Veuillez réessayer",
             ], 400);
         }
     } //end login



}
