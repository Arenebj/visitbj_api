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

    public function createService($name, $description, $price, $place,$city,$type ){
        try{
            return  $this->_paramRepository->createService($name, $description, $price, $place,$city,$type );

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function getService(){
        try{
            return  $this->_paramRepository->getService();

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

    public function addHotel($name, $description, $adresse, $fileName){
        try{
            return  $this->_paramRepository->addHotel($name, $description, $adresse, $fileName);

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
