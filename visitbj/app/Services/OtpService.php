<?php

namespace App\Services;
use Exception;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;
use ClickSend\Api\SmsApi;
use ClickSend\Configuration;
use ClickSend\Model\SmsMessage;
use App\Repositories\AuthRepository;
use App\Models\Code;


class OtpService
{
    protected AuthRepository $_authRepository;
    public function __construct(AuthRepository $authRepository)
    {
       $this->_authRepository = $authRepository;
    }

public function verifyPhoneNumber($phoneNumber)
{
    try {
        // Configurer l'API ClickSend
        $config = Configuration::getDefaultConfiguration()
        ->setUsername(env('YOUR_CLICKSEND_USERNAME'))
        ->setPassword(env('YOUR_CLICKSEND_API_KEY'));

        // Créer une instance de l'API SMS
        $apiInstance = new SMSApi(new \GuzzleHttp\Client(), $config);

        $number = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Créer un tableau contenant les détails du message SMS
        $messages = [
            [
                'body' => $number,
                'to' => $phoneNumber
            ]
        ];

        // Envoyer la requête à l'API ClickSend
        $result = $apiInstance->smsSendPost(['messages' => $messages]);
        $jsonString = $result;
        $data = json_decode($jsonString, true);
        $responseCode = $data['response_code'];
        log::error($jsonString);
        return $responseCode;
        if($responseCode === 'SUCCESS'){
            $newCode = new Code();
            $newCode ->code = $number;
            $newCode ->save();
            return true;
        }


    } catch (Exception $ex) {
        Log::error($ex->getMessage());
        throw new Exception($ex->getMessage());
    }
}

public function verifyPin($verificationCode){
    try{
        return $this->_authRepository->verifyPin($verificationCode);
    }catch( Exception $ex){
        throw new Exception($ex->getMessage());

    }
}





}
