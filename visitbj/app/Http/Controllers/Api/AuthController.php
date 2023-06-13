<?php

namespace App\Http\Controllers\Api;
use App\Models\User;
use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    protected AuthService $_authService;
    protected OtpService $_otpService;
    public function __construct(AuthService $authService, OtpService $otpService)
    {
        $this->_authService = $authService;
        $this->_otpService = $otpService;
    }

/**
 **      @OA\Info(
 *      version="1.0.0",
 *      title=" OpenApi Documentation",
 *      description=" Swagger OpenApi description",
 * )

 * @OA\Post(
 *     path="/celsia/visitbj/public/api/auth/register-user",
 *     tags={"Register"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="last_name", type="string", example="hanane"),
 *             @OA\Property(property="first_name", type="string", example="celsia"),
 *             @OA\Property(property="password", type="string", example="hananecelsia"),
 *             @OA\Property(property="email", type="string", example="hananecelsia@gmail.com"),
 *             @OA\Property(property="phone", type="string", example="+229540757483"),
 *             @OA\Property(property="gender", type="string", example="Feminin"),
 *             @OA\Property(property="birthdate", type="string", example="2002-03-13")
 *         )
 *     ),
 *     @OA\Response(response=201,description="Inscription de l'utilisateur")
 *
 * )
 */

    public function registerUser(Request $request){
        try {
            $phone = (null === $request->get("phone")? null :$request->get("phone")) ;
            $gender = (null === $request->get("gender")? "" :$request->get("gender")) ;
            $birthdate = (null === $request->get("birthdate")?null:$request->get("birthdate")) ;
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
                'phone' => ['nullable', 'unique:users,phone_number' ],
                'password' => ['required', 'min:8']

            ];
            $validationMessages = ['last_name.required' => 'Le prénom est requis', 'first_name.required' => 'Le nom de famille est requis',
            'adresse.unique' => 'Cet numéro de téléphone est déja utilisé','email.required' => "L'adresse email est requis",
             'password.required' => 'Le mot de passe est requis','email.email' => 'Veuillez fournir une adresse email valide',
             'email.unique' => 'Cette adresse email est déja utilisée','phone.unique' => "Ce numéro de téléphone est déjà utilisé." ,
             'password.min' => 'Le mot de passe doit contenir au moins huit caractères',
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


            //do operation
            $resultRegister = $this->_authService->registerUser($lastName, $firstName, $email, $password, $phone, $gender,$birthdate);

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



              /**
 * @OA\Post(
 *     path="/celsia/visitbj/public/api/auth/login-user",
 *     tags={"Login"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="password", type="string", example="hananecelsia"),
 *             @OA\Property(property="email", type="string", example="hananecelsia@gmail.com")
 *
 *         )
 *     ),
 *     @OA\Response(response=200, description="Connexion ."),
 *
 * )
 */
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
                'success' =>true,
                "data" =>$resultRegisterOperation,


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


                  /**
 * @OA\Post(
 *     path="/celsia/visitbj/public/api/auth/send-reset-code",
 *     tags={"Reset code"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="email", type="string", example="mouftaouhanane@gmail.com")
 *
 *         )
 *     ),
 *     @OA\Response(response=200, description="Un code de confirmation a été envoyé à l'adresse pour vérifier son compte."),
 *
 * )
 */
     public function send_reset_code(Request $request){
        try {

            //request data
            $rData =  $request->only(["email"]);

          //validator
          $validatorRules  = [
            'email' => ['required',"exists:users,email"],
          ];

            $validationMessages = [
                'email.required' => "L'adresse email est requise",
                'email.exists' => "L'adresse email n'est pas valide",
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

            //call service
              $resultRegisterOperation = $this->_authService->send_reset_code($email);
              if($resultRegisterOperation === true){
                return response()->json([
                    'success' =>true,
                    'message' => "Un code de confirmation a été envoyé à votre adresse e-mail. Veuillez vérifier votre boîte de réception et saisir le code ci-dessous pour continuer le processus de réinitialisation du mot de passe",
                ], 200);
              }

        }catch (Exception $ex) {
            //error result
            log::error($ex);
            return response()->json([
                'success' => false,
                'message' =>"Une erreur est survenue. Veuillez réessayer",
            ], 400);
        }

     }


                      /**
 * @OA\Post(
 *     path="/celsia/visitbj/public/api/auth/verify-reset-code",
 *     tags={"Verify reset code"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="email", type="string", example="mouftaouhanane@gmail.com"),
 *             @OA\Property(property="code", type="string", example="vhfvg")
 *
 *         )
 *     ),
 *     @OA\Response(response=200, description="Comparer le code saisi par l'utilisateur avec le code généré et envoyé par e-mail."),
 *
 * )
 */

     public function verify_reset_code(Request $request){
        try {

            //request data
            $rData =  $request->only(["code","email"]);

          //validator
          $validatorRules  = [
            'code' => ['required',],
            'email' => ['required',"exists:users,email"],
          ];

            $validationMessages = [
                'code.required' => "Le code est est requise",
                'code.exists' => "Le code n'est pas valide",
                'email.required' => "L'adresse email est requise",
                 'email.exists' => "L'adresse email n'est pas valide",
            ];

            $validatorResult = Validator::make($rData, $validatorRules, $validationMessages);
            if ($validatorResult->fails()) {
                return response()->json([
                  'success' => false,
                  'message' => $validatorResult->errors()->first(), //
                ], 400);
            }

            //get data
            $code = $rData ["code"] ;
            $email = $rData ["email"] ;

            //call service
              $resultRegisterOperation = $this->_authService->verify_reset_code($code, $email);
              return response()->json([
               'data' =>$resultRegisterOperation,
               'message' => "ok",
           ], 200);
        }catch (Exception $ex) {
            //error result
            log::error($ex);
            return response()->json([
                'success' => false,
                'message' =>"Une erreur est survenue. Veuillez réessayer",
            ], 400);
        }

     }

      /**
 * @OA\Post(
 *     path="/celsia/visitbj/public/api/auth/reset-password",
 *     tags={"Reset password"},
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             type="object",
 *             @OA\Property(property="email", type="string", example="mouftaouhanane@gmail.com"),
 *             @OA\Property(property="password", type="string", example="nRTVGbdsxh")

 *
 *         )
 *     ),
 *     @OA\Response(response=200, description="Votre mot de passe a été modifié avec succes."),
 *
 * )
 */

     public function reset_password(Request $request){
        try {

            //request data
            $rData =  $request->only(["password","email"]);


          //validator
          $validatorRules  = [
            'password' => ['required'],
            'email' => ['required',"exists:users,email"],
          ];

            $validationMessages = [
                'password.required' => "Le nouveau password est requis",
                'email.required' => "L'adresse email est requise",
                'email.exists' => "L'adresse email n'est pas valide",
            ];

            $validatorResult = Validator::make($rData, $validatorRules, $validationMessages);
            if ($validatorResult->fails()) {
                return response()->json([
                  'success' => false,
                  'message' => $validatorResult->errors()->first(), //
                ], 400);
            }

            //get data
            $password = $rData ["password"] ;
            $email =$rData["email"];

            //call service
              $resultRegisterOperation = $this->_authService->reset_password($password, $email);
              if($resultRegisterOperation === true){
                return response()->json([
                    'success' =>true,
                    'message' => "Votre mot de passe a été modifié avec succes.",
                ], 200);

              }
              else{
                return response()->json([
                    'success' => false,
                    'message' =>"Une erreur est survenue. Veuillez réessayer",
                ], 400);
              }

        }catch (Exception $ex) {
            //error result
            log::error($ex);
            return response()->json([
                'success' => false,
                'message' =>"Une erreur est survenue. Veuillez réessayer",
            ], 400);
        }

     }

      //generate pin
    protected function generatePin(Request $request)
    {
        try {
          //phone data
            $phoneData = $request->only(["phone_number"]);
            //data validation

            $pinValidationRules = [
                'phone_number' => ['required'],

            ];
            $validationMessages = ['phone_number.required' => 'Le numéros de téléphone est requis'];

            $validator = Validator::make($phoneData, $pinValidationRules, $validationMessages);
            if ($validator->fails()) {
                return response()->json([
                    'data' => $validator->errors(),
                    'status' => "error",
                    'message' => "Veuillez renseigner un numéro de téléphone valide",
                ],  400);
            }
            $dataResult = $request->validate($pinValidationRules);
            $phoneNumber = $dataResult['phone_number'];

            //generate pin
            $resultPinGeneration = $this->_otpService->verifyPhoneNumber($phoneNumber);

            if ($resultPinGeneration === true) {
                return response()->json([

                    'succes' => true,  'message' => "",
                ], 200);
            } else {
                throw new Exception("Une erreur est survenue lors de la génération du code");
            }
        } catch (Exception $ex) {
            log::error($ex);
            //error result
            return response()->json([
                'success' => false,
                'message' => "Une erreur est survenue pendant la génération du PIN. Veuillez vérifier le numéro de téléphone puis réessayer",
            ], 400);
        }
    } //end generatePin

  //verify pin
  protected function verifyPin(Request $request)
  {
      try {
          //request data
          $rData =  $request->only(["verification_code"]);

          //verify step
          $pinVerifyRules = [
              'verification_code' => ['required'],
          ];
          $validationMessages = [
              'verification_code.required' => 'Le code de vérification est requis'
          ];

          $validator = Validator::make($rData, $pinVerifyRules, $validationMessages);
          if ($validator->fails()) {
              return response()->json([
                  'data' => $validator->errors(),
                  'status' => "error",
                  'message' => "Veuillez renseigner un code valide",
              ], 400);
          }
          $dataResult = $request->validate($pinVerifyRules);

          $verificationCode = $dataResult['verification_code'];

          //verify
          $resultPinVerification = $this->_otpService->verifyPin($verificationCode);

          if ($resultPinVerification) {
              //status
              return response()->json([
                  'success' => false,
                  'message' => "Le code de vérification est valide",
              ], 200);
          }

          return array(
              "success" => "false",
              "message" => "Le code fourni n'est pas valide",
          );
      } catch (Exception $ex) {
          //log exception
          //error result
          return response()->json([
              'success' => "false",
              'message' => "Le code temporaire est soit incorrect, soit déjà utilisé. Veuillez corriger puis réessayer",
          ], 400);
      } catch (Exception $ex) {
          //log exception
          //error result
          return response()->json([
              'data' => "",
              'status' => "error",
              'message' => $ex->getMessage(),
          ], 400);
      }
      catch (Exception $ex) {

          //log exception
          //error result
          return response()->json([
              'success' => false,
              'message' => "Une erreur est survenue pendant la vérification du code temporaire. Veuillez réessayer",
          ], 400);
      }
  } //end verifyPin*/





}
