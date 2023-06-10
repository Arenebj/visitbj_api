<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParamService;
use App\Services\FileService;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ThemeController extends Controller
{
    protected ParamService $_paramService;
    protected FileService $_fileService;
    public function __construct(ParamService $paramService, FileService $fileService)
    {
        $this->_paramService = $paramService;
        $this->_fileService = $fileService;
    }

    public function  createTheme(Request $request){
        try{
            $rData=$request->only(['name']);
            $validator=[
                'name' => ['required'],
            ];
            $validationMessages = [
                'name.required' => "Le nom est requis",
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
                        //todo: mettre dans un service
            $file=$request->file('cover');

                        //do operation
            $fileName = $this->_fileService->saveImage( $file);
                       //check error
                if (!$fileName) {
                     throw new Exception("Veuillez fournir une photo du theme");
                }
            $result = $this->_paramService->createTheme($name, $fileName);
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
                    "message"=> "Une erreur est survenue. Veuillez réessayer",
                ]
                );
        }
    }


    public function  getTheme(){
        try{

            $result = $this->_paramService->getTheme();

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
                    "message"=> "Une erreur est survenue pour lister les catégories de park. Veuillez réessayer",
                ]
                );
        }
    }

}
