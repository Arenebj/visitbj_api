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

    //
}
