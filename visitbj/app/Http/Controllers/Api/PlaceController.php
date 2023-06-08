<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParamService;
use App\Services\FileService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class PlaceController extends Controller
{
    protected ParamService $_paramService;
    protected FileService $_fileService;
    public function __construct(ParamService $paramService, FileService $fileService)
    {
        $this->_paramService = $paramService;
        $this->_fileService = $fileService;
    }

    public function  createPlace(Request $request){
        try{
            $rData=$request->only(['name', 'description', 'longitude','latitude','city_id']);
            $validator=[
                'name' => ['required'],
                'description' => ['required'],
                'longitude' => ['required'],
                'latitude' => ['required'],
                'city_id' => ['required','exists:cities,id'],
            ];
            $validationMessages = [
                'name.required' => "Le nom de la ville est requis",
                'description.required' => "Une description de la ville  est requise",
                'longitude.required' => "La longitude de la ville est requise",
                'latitude.required' => "La latitude de la ville est requise",
                'city_id.required' => "L'identifiant de la ville est requise",
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
            $city =  $rData['city_id'];

              //save file
            //todo: mettre dans un service
            $file=$request->file('cover');

             //do operation
             $fileName = $this->_fileService->saveImage( $file);
            //check error
            if (!$fileName) {
              throw new Exception("Veuillez fournir une photo de la ville");
            }

            $result = $this->_paramService->createPlace($name, $description, $longitude, $latitude, $city, $fileName);
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
                       "status"=> true,
                        "message"=> "succes",
                    ]
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


    public function  getPlace(){
        try{

            $result = $this->_paramService->getPlace();

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
                    "message"=> "Une erreur est survenue pour lister les destinations. Veuillez réessayer",
                ]
                );
        }
    }

}
