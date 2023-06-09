<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParamService;
use App\Services\FileService;
use Illuminate\Support\Facades\Log;
use Exception;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
    protected ParamService $_paramService;
    public function __construct(ParamService $paramService)
    {
        $this->_paramService = $paramService;
    }
    public function  createActivity(Request $request){
        try{
            $rData=$request->only(['name', 'description', 'price','place_id']);
            $validator=[
                'name' => ['required'],
                'description' => ['required'],
                'price' => ['required'],
                'place_id' => ['required', 'exists:places,id'],
            ];
            $validationMessages = [
                'name.required' => "Le nom de la ville est requis",
                'description.required' => "Une description de l'activité est requise",
                'price.required' => "Le prix de l'activité est requis",
                'place_id.required' => "L'identifiant de la destination est requis",
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
            $place =  $rData['place_id'];

            $result = $this->_paramService->createActivity($name, $description, $price, $place);
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
                    "message"=> "Une erreur est survenue lors de la création d'une activité. Veuillez réessayer",
                ]
                );
        }
    }


    public function  getActivity(){
        try{

            $result = $this->_paramService->getActivity();

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
                    "message"=> "Une erreur est survenue pour lister les activités. Veuillez réessayer",
                ]
                );
        }
    }


    //
}
