<?php

namespace App\Interfaces;


interface ParamRepositoryInterface
{

    public function getService();
    public function createService($name, $description, $price, $place,$city,$type );
    public function createTheme($name, $fileName);
    public function getTheme();
    public function addHotel($name, $description, $adresse, $fileName);
    public function getHotel();

    //
}
