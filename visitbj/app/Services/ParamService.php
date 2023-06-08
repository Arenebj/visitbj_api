<?php

namespace App\Services;
use App\Repositories\ParamRepository;
use Exception;
class ParamService
{

    public ParamRepository $_paramRepository;
    public function __construct(ParamRepository $paramRepository)
    {
        $this->_paramRepository = $paramRepository;
    }
    //
    public function createCity($name, $description, $longitude, $latitude, $fileName){
        try{
            return  $this->_paramRepository->createCity($name, $description, $longitude, $latitude, $fileName);

        }catch(Exception $ex){

        }
    }

    public function getCity(){
    try{
        return  $this->_paramRepository->getCity();

    }catch(Exception $ex){
        throw new Exception($ex);
    }}

    public function createPlace($name, $description, $longitude, $latitude, $city, $fileName){
        try{
            return  $this->_paramRepository->createPlace($name, $description, $longitude, $latitude, $city, $fileName);

        }catch(Exception $ex){
            throw new Exception($ex);

    }}

    public function getPlace(){
    try{
        return  $this->_paramRepository->getPlace();

    }catch(Exception $ex){
        throw new Exception($ex);
    }}

    public function createActivity($name, $description, $price, $place){
        try{
            return  $this->_paramRepository->createActivity($name, $description, $price, $place);

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function getActivity(){
        try{
            return  $this->_paramRepository->getActivity();

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }
}
