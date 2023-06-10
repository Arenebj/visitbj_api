<?php

namespace App\Repositories;
use App\Interfaces\OperationRepositoryInterface;
use App\Models\Pack;
use App\Models\MediaPark;
use App\Models\Step;
use App\Models\StepService;
use App\Models\StepHebergement;
use Exception;
use App\Models\UserPack;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class OperationRepository implements  OperationRepositoryInterface
{
    public function compositionPark($name, $description, $price, $type, $plannings, $theme, $duration, $limitPerson ){
        try{
            DB::beginTransaction();
            try{

            $park = new Pack();
            $park->name = $name;
            $park->description = $description;
            $park->price = $price;
            $park->type = $type;
            $park->duration = $duration;
            $park->theme_id = $theme;
            $park->save();
            foreach ($plannings as $planning){
                $step = new Step();
                $step->number =$planning['number'];
                $step->distance =$planning['distance'];
                $step->park_id = $park->id;
                $step->save();

                foreach ($planning['activities'] as $activity){
                    //activities in day
                    $stepService= new StepService();
                    $stepService->step_id =  $step->id;
                    $stepService->service_id =  $activity;
                    $stepService->save();
                }

                if(isset($planning['hotel'])){
                    $stepHebergement= new StepHebergement();
                    $stepHebergement->step_id =  $step->id;
                    $stepHebergement->hotel_id =  $planning['hotel'];
                    $stepService->save();
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
            $packs = Pack::with('theme','media_parks',"steps.step_hebergements","steps.services")->get();
            return $packs;

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }

    public function detailPack($idPack){
        try{
            $packFound = Pack::where('id',$idPack)-with('theme','media_parks',"steps.step_hebergements","steps.services")->first();
            return $packFound;

        }catch(Exception $ex){
            throw new Exception($ex);
        }

    }

    public function searchPackByTheme($idTheme){
        try{
            $packs =Pack::where('therme_id',$idTheme)->with('theme','media_parks',"steps.step_hebergements","steps.services")->get();

        }catch(Exception $ex){
            throw new Exception($ex);
        }
    }


    public function reservationOfPack($userId, $packId, $nbrPerson){
        try{
            $typePack = Pack::where('id',$packId)->first()->type;
            if($typePack === 'fixed' && $nbrPerson !== null){
                throw new Exception("Cest un pack de type fixe .Impossible d'effectuer une modificaction");
            }

            $reservation = new UserPack();
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
