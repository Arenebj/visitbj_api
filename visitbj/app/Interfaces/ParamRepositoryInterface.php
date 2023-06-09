<?php

namespace App\Interfaces;


interface ParamRepositoryInterface
{
    public function createCity($name, $description, $longitude, $latitude, $fileName);
    public function getCity();
    public function createPlace($name, $description, $longitude, $latitude, $city, $fileName);
    public function getPlace();
    public function getActivity();
    public function createActivity($name, $description, $price, $place);
    public function createEvent($name, $description, $price, $place, $startDate, $endDate);
    public function getEvent();
    public function createTheme($name, $fileName);
    public function getTheme();
    public function addHotel($name, $description, $adresse, $city, $fileName);
    public function getHotel();

    //
}
