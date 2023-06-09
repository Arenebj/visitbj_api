<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\FileService;
use Illuminate\Http\Request;
use App\Services\ParamService;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Log;

class HotelController extends Controller
{
    protected ParamService $_paramService;
    protected FileService $_fileService;
    public function __construct(ParamService $paramService, FileService $fileService )
    {
        $this->_paramService = $paramService;
        $this->_fileService = $fileService;
    }


    public function addHotel(Request $request){
        try{
            $rData=$request->only(['name', 'description', 'adresse','city_id']);
            $validator=[
                'name' => ['required'],
                'description' => ['required'],
                'adresse' => ['required'],
                'city_id' => ['required','exists:cities,id'],
            ];
            $validationMessages = [
                'name.required' => "Le nom de la ville est requis",
                'description.required' => "Une description de la ville  est requise",
                'adresse.required' => "L'adresse de l'hotel est requis",
                'city_id.required' => "L'identifiant de la ville est requis",
                'city_id.exists' => "L'identifiant de la ville est requis",
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
            $adresse =  $rData['adresse'];
            $city =  $rData['city_id'];

              //save file
            //todo: mettre dans un service
            $file=$request->file('cover');

             //do operation
             $fileName = $this->_fileService->saveImage( $file);
            //check error
            if (!$fileName) {
              throw new Exception("Veuillez fournir une photo de l'hotel");
            }

            $result = $this->_paramService->addHotel($name, $description, $adresse, $city, $fileName);
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
                    "message"=> "Une erreur est survenue lors de l'ajout de la ville. Veuillez réessayer",
                ]
                );
        }
    }


    public function  getCity(){
        try{

            $result = $this->_paramService->getCity();

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
                    "message"=> "Une erreur est survenue pour lister les villes. Veuillez réessayer",
                ]
                );
        }
    }

}
