<?php
namespace App\Interfaces;

interface OperationRepositoryInterface
{
    public function compositionPark($name, $description, $price, $type, $plannings, $theme, $duration, $exclusion, $startDate, $endDate, $limitPerson);
    public function getPack();
    public function detailPack($idPack);
    public function searchPackByTheme($idTheme);
    public function reservationOfPack($userId, $packId, $nbrPerson);
    //
}
