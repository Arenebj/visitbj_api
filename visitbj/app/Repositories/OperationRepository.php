<?php

namespace App\Repositories;
use App\Interfaces\OperationRepositoryInterface;
use App\Models\ActivitiesDay;
use App\Models\Activity;
use App\Models\Planning;
use App\Models\City;
use App\Models\Event;
use App\Models\Park;
use App\Models\EventsDay;
use App\Models\DayHotel;
use App\Models\HotelsDay;
use App\Models\MediaPark;
use App\Models\Reservation;
use Exception;
use App\Models\Theme;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class OperationRepository implements  OperationRepositoryInterface
{
    public function compositionPark($name, $description, $price, $type, $plannings, $theme, $duration, $exclusion, $startDate, $endDate,$limitPerson ){
        try{
            DB::beginTransaction();
            try{

            $park = new Park();
            $park->name = $name;
            $park->description = $description;
            $park->price = $price;
            $park->type = $type;
            $park->duration = $duration;
            $park->theme_id = $theme;
            $park->exclusion = $exclusion;
            $park->start_date = $startDate;
            $park->end_date = $endDate;
            $park->save();
            foreach ($plannings as $planning){
                $dayPark = new Planning();
                $dayPark->number =$planning['number'];
               // $dayPark->travel_time =$planning['travel_time'];
                $dayPark->distance =$planning['distance'];
                $dayPark->park_id = $park->id;
                $dayPark->save();

                foreach ($planning['activities'] as $activity){
                    //activities in day
                    $activityDay = new ActivitiesDay();
                    $activityDay->planning_id =  $dayPark->id;
                    $activityDay->activity_id =  $activity;
                    $activityDay->save();
                }
                if(isset($planning['events'])){
                    foreach ($planning['events'] as $event){
                        $eventDay = new EventsDay();
                        $eventDay->planning_id =  $dayPark->id;
                        $eventDay->event_id =  $event;
                        $eventDay->save();
                    }
                }
                if(isset($planning['hotel'])){
                $hotelDay = new HotelsDay();
                $hotelDay->planning_id =  $dayPark->id;
                $hotelDay->hotel_id =  $planning['hotel'];
                $hotelDay->save();
                }};
                DB::commit();
                return true;

            }catch(Exception $ex){
                DB::rollback();
                log::error( $ex->getMessage());


            }



        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function getPack()
    {
        try{
            $packs = Park::with('theme','plannings.activities_days.activity','plannings.events_days.event','plannings.hotels_days.hotel','media_parks')->get();
            return $packs;

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function detailPack($idPack){
        try{
            $packFound = Park::where('id',$idPack)->with('theme','plannings.activities_days.activity','plannings.events_days.event','plannings.hotels_days.hotel','media_parks')->first();
            return $packFound;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function searchPackByTheme($idTheme){
        try{
            $packs =Park::where('therme_id',$idTheme)->with('theme','plannings.activities_days.activity','plannings.events_days.event','plannings.hotels_days.hotel','media_parks')->get();

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }


    public function reservationOfPack($userId, $packId, $nbrPerson){
        try{
            $typePack = Park::where('id',$packId)->first()->type;
            if($typePack === 'fixed' && $nbrPerson !== null){
                throw new Exception("Cest un pack de type fixe .Impossible d'effectuer une modificaction");
            }

            $reservation = new Reservation();
            $reservation->user_id = $userId;
            $reservation->park_id = $packId;

           if ($typePack->type === 'standard') {
              $reservation->nombre_participants = $nbrPerson;
           }

          $reservation->save();
        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function addMediaToPack($packId, $fileName, $extension){
        try{
            log::error($extension);
            $extensionsImages = ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'tiff', 'webp', 'svg', 'ico', 'jfif', 'jpe', 'jif', 'jfi', 'jp2', 'jpx', 'j2k', 'j2c', 'heif', 'bat', 'raw'];
            $extensionsVideos = ['mp4', 'avi', 'mov', 'wmv', 'flv', 'mkv', 'webm', 'm4v', 'mpg', 'mpeg', '3gp', '3g2', 'rm', 'rmvb', 'swf', 'vob'];


            $mediaPack = new MediaPark();
            $mediaPack ->pack_id = $packId;
            $mediaPack ->path = $fileName;

            if(in_array($extension,$extensionsImages )){
                $mediaPack ->type = "image";

            }elseif(in_array($extension,$extensionsVideos)){
                $mediaPack ->type = "vidéo";

            }

            $mediaPack ->save();
            return true;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

}
