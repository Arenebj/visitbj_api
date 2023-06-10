<?php

namespace App\Repositories;
use App\Interfaces\ParamRepositoryInterface;
use App\Models\Hotel;
use Exception;
use App\Models\Theme;
use App\Models\Service;



class ParamRepository implements  ParamRepositoryInterface
{


    public function createService($name, $description, $price, $place,$city,$type ){
        try{
            $service = new Service();
            $service->name = $name;
            $service->description = $description;
            $service->price = $price;
            $service->place= $place;
            $service->city= $city;
            $service->type= $type;
            $service->save();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }


    public function getService(){
        try{
            $services = Service::all();
            return $services;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }


    public function createTheme($name, $fileName){
        try{
            $theme = new Theme();
            $theme->label = $name;
            $theme->cover = $fileName;
            $theme->save();
            return true;
        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }


    public function getTheme(){
        try{
            $themes = Theme::all();
            return $themes;

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function addHotel($name, $description, $adresse, $fileName){
        try{
            $hotel = new Hotel();
            $hotel->name = $name;
            $hotel->description = $description;
            $hotel->adresse = $adresse;
            $hotel->cover = $fileName;
            $hotel->save();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function getHotel(){
        try{
            $hotels = Hotel::all();
            return  $hotels;
        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }
    //
}
