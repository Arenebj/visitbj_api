<?php

namespace App\Services;
use App\Repositories\OperationRepository;
use Exception;
class OperationService
{

    public OperationRepository $_operationRepository;
    public function __construct(OperationRepository $operationRepository)
    {
        $this->_operationRepository = $operationRepository;
    }
    //
    public function compositionPark($name, $description, $price, $type, $plannings, $theme, $duration, $limitPerson){
        try{
            return  $this->_operationRepository->compositionPark($name, $description, $price, $type, $plannings, $theme, $duration,$limitPerson);

        }catch(Exception $ex){
            throw new Exception($ex);
        }


    }

    public function getPack(){
        try{
            return  $this->_operationRepository->getPack();

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function detailPack($idPack){
        try{
            return $this->_operationRepository->detailPack($idPack);

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function searchPackByTheme($idTheme){
        try{
            return $this->_operationRepository->searchPackByTheme($idTheme);

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

   /* public function reservationOfPack($userId, $packId, $nbrPerson){
        try{
            return $this->_operationRepository-> reservationOfPack($userId, $packId, $nbrPerson);

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }*/

    public function addMediaToPack($packId, $fileName, $extension){
        try{
            return $this->_operationRepository-> addMediaToPack($packId, $fileName, $extension);

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }
}
