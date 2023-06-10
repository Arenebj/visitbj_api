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
            $rData=$request->only(['name', 'description', 'adresse']);
            $validator=[
                'name' => ['required'],
                'description' => ['required'],
                'adresse' => ['required'],
            ];
            $validationMessages = [
                'name.required' => "Le nom de la ville est requis",
                'description.required' => "Une description de la ville  est requise",
                'adresse.required' => "L'adresse de l'hotel est requis",
            ];
            $validatorResult=Validator::make( $rData, $validator, $validationMessages);

            if ($validatorResult->fails()) {
                return response()->json([
                    'succcess' => false,
                    'message' => $validatorResult->errors()->first(),
                ], 400);
            }
            $name =  $rData['name'];
            $description =  $rData['description'];
            $adresse =  $rData['adresse'];

            $file=$request->file('cover');

             //do operation
             $fileName = $this->_fileService->saveImage( $file);
            //check error
            if (!$fileName) {
              throw new Exception("Veuillez fournir une photo de l'hotel");
            }

            $result = $this->_paramService->addHotel($name, $description, $adresse, $fileName);
            if($result  === false){
                return response()->json(
                    [
                        "success"=> false,
                        "message"=> "Une erreur est survenue lors de l'ajout de la ville. Veuillez réessayer",
                    ]
                    );
            }else{
                return response()->json(
                    [
                       "success"=> true,
                        "message"=> "L'hôtel a été enregistré avec succès.",
                    ],201
                    );

            }

        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [
                   "success"=> false,
                    "message"=> "Une erreur est survenue lors de l'ajout de la ville. Veuillez réessayer",
                ]
                );
        }
    }


    public function  getHotel(){
        try{

            $result = $this->_paramService->getHotel();

                return response()->json(
                    [
                        "data"=> $result,
                        "success"=> true,
                        "message"=> "succes",
                    ]
                    );
        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [
                   "status"=> false,
                    "message"=> "Une erreur est survenue pour lister les hotels. Veuillez réessayer",
                ]
                );
        }
    }

}
