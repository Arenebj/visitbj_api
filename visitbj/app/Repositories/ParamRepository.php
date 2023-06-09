<?php

namespace App\Repositories;
use App\Interfaces\ParamRepositoryInterface;
use App\Models\Activity;
use App\Models\City;
use App\Models\Event;
use App\Models\Hotel;
use App\Models\Place;
use Exception;
use App\Models\Theme;


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
            return true;

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
            $place->save();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function getPlace(){
        try{
            $places = Place::with('city')->get();
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
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }


    public function getActivity(){
        try{
            $activities = Activity::with('place')->get();
            return $activities;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function createEvent($name, $description, $price, $place, $startDate, $endDate){
        try{
            $event = new Event();
            $event->name = $name;
            $event->description = $description;
            $event->price = $price;
            $event->place_id = $place;
            $event->start_date = $startDate;
            $event->end_date = $endDate;
            $event->save();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function getEvent(){
    try{
        $events = Event::with('place')->get();
        return $events;
    }catch(Exception $ex){
        throw new Exception($ex);
    }}

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

    public function addHotel($name, $description, $adresse, $city, $fileName){
        try{
            $hotel = new Hotel();
            $hotel->name = $name;
            $hotel->description = $description;
            $hotel->adresse = $adresse;
            $hotel->city = $city;
            $hotel->cover = $fileName;
            $hotel->save();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function getHotel(){
        try{
            $hotels = Hotel::with('city')->get();
            return  $hotels;
        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }
    //
}
