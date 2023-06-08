<?php

namespace App\Repositories;
use App\Interfaces\ParamRepositoryInterface;
use App\Models\Activity;
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
            $place->city_id = $city;
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
        try{
            $activity = new Activity();
            $activity->name = $name;
            $activity->description = $description;
            $activity->price = $price;
            $activity->place_id = $place;
            $activity->save();

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }


    public function getActivity(){
        try{
            $activities = Activity::all();
            return $activities;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    //
}
