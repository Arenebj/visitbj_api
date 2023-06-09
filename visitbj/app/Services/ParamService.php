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

    public function createEvent($name, $description, $price, $place, $startDate, $endDate){
        try{
            return  $this->_paramRepository->createEvent($name, $description, $price, $place, $startDate, $endDate);

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function getEvent(){
        try{
            return  $this->_paramRepository->getEvent();

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }


    public function createTheme($name, $fileName){
        try{
            return  $this->_paramRepository->createTheme($name, $fileName);

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }


    public function getTheme(){
        try{
            return  $this->_paramRepository->getTheme();

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function addHotel($name, $description, $adresse, $city, $fileName){
        try{
            return  $this->_paramRepository->addHotel($name, $description, $adresse, $city, $fileName);

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function getHotel(){
        try{
            return  $this->_paramRepository->getHotel();

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

}
