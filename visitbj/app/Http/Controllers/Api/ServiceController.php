<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParamService;
use App\Services\FileService;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Type\TrueType;

class ServiceController extends Controller
{
    protected ParamService $_paramService;
    public function __construct(ParamService $paramService)
    {
        $this->_paramService = $paramService;
    }
    public function  createService(Request $request){
        try{
            $rData=$request->only(['name', 'description', 'price','place', 'city', 'type']);
            $validator=[
                'name' => ['required'],
                'description' => ['required'],
                'price' => ['required'],
                'place' => ['required'],
                'city' => ['required'],
                'type' => ['required'],
            ];
            $validationMessages = [
                'name.required' => "Le nom du service est requis",
                'description.required' => "Une description du service est requise",
                'price.required' => "Le prix du service est requis",
                'place.required' => "La place du service est requise",
                'city.required' => "La ville est requise",
                'type.required' => "Le type du service est requis",
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
            $place =  $rData['place'];
            $city =  $rData['city'];
            $type =  $rData['type'];

            $result = $this->_paramService->createService($name, $description, $price, $place, $city, $type);
            if($result  === false){
                return response()->json(
                    [
                        "success"=> false,
                        "message"=> "error",
                    ]
                    );
            }else{
                return response()->json(
                    [
                       "success"=> True,
                        "message"=> "Le service a été enregistré avec succès.",
                    ],201
                    );

            }

        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [
                   "status"=> false,
                    "message"=> "Une erreur est survenue lors de la création d'un service. Veuillez réessayer",
                ]
                );
        }
    }


    public function  getService(){
        try{

            $result = $this->_paramService->getService();

                return response()->json(
                    [
                        "data"=> $result,
                        "success"=> true,
                    ]
                    );
        }catch(Exception $ex){
            log::error($ex->getMessage());
            return response()->json(
                [
                   "status"=> false,
                    "message"=> "Une erreur est survenue pour lister les services. Veuillez réessayer",
                ]
                );
        }
    }


    //
}
