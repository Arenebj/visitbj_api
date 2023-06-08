<?php

namespace App\Repositories;
use App\Interfaces\ParamRepositoryInterface;
use App\Models\City;
use App\Models\Place;
use Exception;

class ParamRepository implements  ParamRepositoryInterface
{

    public function createCity($name, $description, $longitude, $latitude, $fileName){
        try{
            $city = new City();
            $city->name = $name;
            $city->description = $description;
            $city->longitude = $longitude;
            $city->latitude = $latitude;
            $city->cover = $fileName;
            $city->save();

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }
    //

    public function getCity(){
        try{
            $cities = City::all();
            return $cities;

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function createPlace($name, $description, $longitude, $latitude, $city, $fileName){
        try{
            $place = new Place();
            $place->name = $name;
            $place->description = $description;
            $place->longitude = $longitude;
            $place->latitude = $latitude;
            $place->cover = $fileName;
            $place->id_city = $city;
            $city->save();

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function getPlace(){
        try{
            $places = Place::all();
            return $places;

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function createActivity($name, $description, $price, $place){

    }


    public function getActivity(){

    }

    //
}
