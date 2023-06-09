<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Services\FileService;
use Illuminate\Http\Request;
use App\Services\OperationService;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Log;

class PackController extends Controller
{
    protected OperationService $_operationService;
    protected FileService $_fileService;
    public function __construct(OperationService $operationService, FileService $fileService)
    {
        $this->_operationService = $operationService;
        $this->_fileService = $fileService;
    }


    public function compositionPark(Request $request){
        try{

            $limitPerson = (null === $request->get("limit_person"))? null  : $request->get("limit_person") ;
            $exclusion = (null === $request->get("exclusion"))? null  : $request->get("exclusion") ;
            $startDate = (null === $request->get("start_date"))? null  : $request->get("start_date") ;
            $endDate = (null === $request->get("end_date"))? null  : $request->get("end_date") ;

            $rData=$request->only(['name', 'description', 'type','price', 'duration','plannings', 'theme']);

            $validator=[
                'name' => ['required'],
                'description' => ['required'],
                'type' => ['required'],
                'duration' => ['required'],
                'price' => ['required'],
                'plannings' => ['required'],
                'theme' => ['required','exists:theme,id'],
            ];
            $validationMessages = [
                'name.required' => "Le nom de la ville est requis",
                'description.required' => "Une description du park est requise",
                'type.required' => "Le type du park est requis",
                'price.required' => "Le prix du park  est requis",
                'plannings.required' => "Le plan du park est requis",
                'theme.required' => "Le theme du park est requis ",
                'duration.required' => "La durée du park est requis ",

            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                   'status' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $name =  $rData['name'];
            $description =  $rData['description'];
            $price =  $rData['price'];
            $type =  $rData['type'];
            $plannings =  $rData['plannings'];
            $theme =  $rData['theme'];
            $duration =  $rData['duration'];

            $result = $this->_operationService->compositionPark($name, $description, $price, $type, $plannings, $theme, $duration, $exclusion, $startDate, $endDate, $limitPerson);
            if($result  === false){
                return response()->json(
                    [
                        "status"=> false,
                        "message"=> "error",
                    ]
                    );
            }else{
                return response()->json(
                    [
                        "data"=> $result,
                       "status"=> 200,
                        "message"=> "succes",
                    ],201
                    );
            }

        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [
                   "status"=> false,
                    "message"=> "Une erreur est survenue lors de la création d'un évenement. Veuillez réessayer",
                ]
                );
        }
    }



    public function  getPack(){
        try{

            $result = $this->_operationService->getPack();

                return response()->json(
                    [
                        "data"=> $result,
                       "status"=> true,
                        "message"=> "succes",
                    ]
                    );
        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [
                   "status"=> false,
                    "message"=> "Une erreur est survenue pour lister les packs. Veuillez réessayer",
                ],400
                );
        }
    }

    public function  detailPack(Request $request){
        try{
            $rData=$request->only(['pack_id']);
            $validator=[
                'pack_id' => ['required',"exists:parks,id"],
            ];
            $validationMessages = [
                'pack_id.required' => "L'identifiant du park est requis",
                'pack_id.exists' => "L'identifiant du park n'est pas valide",

            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                   'status' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $idPack =  $rData['pack_id'];

            $result = $this->_operationService->detailPack($idPack);
            if($result  === false){
                return response()->json(
                    [
                        "status"=> false,
                        "message"=> "error",
                    ],400
                    );
            }else{
                return response()->json(
                    [
                        "data"=> $result,
                       "status"=> 200,
                        "message"=> "succes",
                    ],200
                    );

            }

        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [
                   "status"=> false,
                    "message"=> "Une erreur est survenue. Veuillez réessayer",
                ]
                );
        }
    }


    public function  searchPackByTheme(Request $request){
        try{
            $rData=$request->only(['theme_id']);
            $validator=[
                'theme_id' => ['required',"exists:theme,id"],
            ];
            $validationMessages = [
                'theme_id.required' => "L'identifiant de la catégorie du pack est requis",
                'theme_id.exists' => "L'identifiant de la catégorie du pack n'est pas valide",

            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                   'status' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $idTheme =  $rData['theme_id'];

            $result = $this->_operationService->searchPackByTheme($idTheme);
            if($result  === false){
                return response()->json(
                    [
                        "status"=> false,
                        "message"=> "error",
                    ],400
                    );
            }else{
                return response()->json(
                    [
                        "data"=> $result,
                       "status"=> 200,
                        "message"=> "succes",
                    ],200
                    );

            }

        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [
                   "status"=> false,
                    "message"=> "Une erreur est survenue. Veuillez réessayer",
                ]
                );
        }
    }

    public function reservationOfPack(Request $request){
        try{$rData=$request->only(['user_id',"pack_id","nombre_of_participant"]);
            $validator=[
                'user_id' => ['required',"exists:users,id"],
                'pack_id' => ['required',"exists:parks,id"],
            ];
            $validationMessages = [
                'user_id.required' => "L'identifiant de l'utilisateur est requis",
                'pack_id.required' => "L'identifiant du pack est requis",
                'pack_id.exists' => "L'identifiant du pack n'est pas valide",

            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                   'status' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $userId =  $rData['user_id'];
            $packId =  $rData['pack_id'];
            $nbrPerson =  $rData['nombre_of_participant'];

            $result = $this->_operationService->reservationOfPack($userId, $packId, $nbrPerson);
            if($result  === false){
                return response()->json(
                    [
                        "status"=> false,
                        "message"=> "error",
                    ],400
                    );
            }else{
                return response()->json(
                    [
                        "data"=> $result,
                       "status"=> 200,
                        "message"=> "succes",
                    ],200
                    );

            }

        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [
                   "status"=> false,
                    "message"=> "Une erreur est survenue. Veuillez réessayer",
                ]
                );
        }

    }


    public function addMediaToPack(Request $request){
        try{$rData=$request->only(["pack_id"]);
            $validator=[
                'pack_id' => ['required',"exists:parks,id"],
            ];
            $validationMessages = [
                'pack_id.required' => "L'identifiant du pack est requis",
                'pack_id.exists' => "L'identifiant du pack n'est pas valide",

            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'data' => $validatorResult->errors()->first(),
                   'status' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }

            $packId =  $rData['pack_id'];
              //save file
            //todo: mettre dans un service
            $file=$request->file('cover');
            $extension = $file->getClientOriginalExtension();

             //do operation
             $fileName = $this->_fileService->saveImage( $file);
            //check error
            if (!$fileName) {
              throw new Exception("Veuillez fournir une photo ou une vidéo du pack");
            }


            $result = $this->_operationService->addMediaToPack($packId, $fileName, $extension);
            if($result  === false){
                return response()->json(
                    [
                        "status"=> false,
                        "message"=> "error",
                    ],400
                    );
            }else{
                return response()->json(
                    [
                        "data"=> $result,
                       "status"=> 200,
                        "message"=> "succes",
                    ],201
                    );

            }

        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [
                   "status"=> false,
                    "message"=> "Une erreur est survenue. Veuillez réessayer",
                ]
                );
        }

    }


}
