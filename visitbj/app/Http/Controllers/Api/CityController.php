<?php

namespace App\Http\Controllers\Api;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParamService;
use App\Services\FileService;
use Exception;
use Illuminate\Support\Facades\Validator;


class CityController extends Controller
{
    protected ParamService $_paramService;
    protected FileService $_fileService;
    public function __construct(ParamService $paramService, FileService $fileService)
    {
        $this->_paramService = $paramService;
        $this->_fileService = $fileService;
    }

    public function  createCity(Request $request){
        try{
            $rData=$request->only(['name', 'description', 'longitude','latitude']);
            $validator=[
                'name' => ['required'],
                'description' => ['required'],
                'longitude' => ['required'],
                'latitude' => ['required'],
            ];
            $validationMessages = [
                'name.required' => "Le nom de la ville est requis",
                'description.required' => "Une description de la ville  est requise",
                'longitude.required' => "La longitude de la ville est requise",
                'latitude.required' => "La latitude de la ville est requise",
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
            $longitude =  $rData['longitude'];
            $latitude =  $rData['latitude'];

              //save file
            //todo: mettre dans un service
            $file=$request->file('cover');

             //do operation
             $fileName = $this->_fileService->saveImage( $file);
            //check error
            if (!$fileName) {
              throw new Exception("Veuillez fournir une photo de la ville");
            }

            $result = $this->_paramService->createCity($name, $description, $longitude, $latitude, $fileName);
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
