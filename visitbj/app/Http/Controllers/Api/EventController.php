<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ParamService;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Log;


class EventController extends Controller
{
    protected ParamService $_paramService;
    public function __construct(ParamService $paramService)
    {
        $this->_paramService = $paramService;
    }

    public function  createEvent(Request $request){
        try{
            $rData=$request->only(['name', 'description', 'price','start_date', 'end_date','place_id']);
            $validator=[
                'name' => ['required'],
                'description' => ['required'],
                'price' => ['required'],
                'place_id' => ['required', 'exists:places,id'],
                'start_date' => ['required'],
                'end_date' => ['required'],
            ];
            $validationMessages = [
                'name.required' => "Le nom de la ville est requis",
                'description.required' => "Une description de l'activité est requise",
                'price.required' => "Le prix de l'activité est requis",
                'place_id.required' => "L'identifiant de la destination est requis",
                'start_date.required' => "La date de début de l'évenement est requise",
                'end_date.required' => "La date de fin de l'évenement est requis",
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
            $startDate =  $rData['start_date'];
            $endDate =  $rData['end_date'];

            $result = $this->_paramService->createEvent($name, $description, $price, $place, $startDate, $endDate);
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


    public function  getEvent(){
        try{

            $result = $this->_paramService->getEvent();

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
                    "message"=> "Une erreur est survenue pour lister les évenements. Veuillez réessayer",
                ]
                );
        }
    }

}
