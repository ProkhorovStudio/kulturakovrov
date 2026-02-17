<?php
namespace Prokhorov\Checkwh;

use Prokhorov\Checkwh\Data;
use Bitrix\Main\Loader;
class Api
{

    
    
    public static function checkWh($dataUser) {

        if($dataUser['PROPERTY_ATT_PHONE_VALUE']){

            $phone = $dataUser['PROPERTY_ATT_PHONE_VALUE'];


            /*Тут логика отправки данных в API*/

            $httpClient = new \Bitrix\Main\Web\HttpClient();

            $url = 'https://whatsgate.ru/api/v1/check';

            $httpClient->setHeader('X-Api-Key', 'P0Xtoz1yl0TbozOP430CmYPsLbRe7f_v', true);
            $httpClient->setHeader('Content-Type', 'application/json', true);

            $sendArray = [
                "WhatsappID" => '6810cdc8b8d78',
                "number" => $phone
            ];

            $response = $httpClient->post($url, \Bitrix\Main\Web\Json::encode($sendArray));

            // Преобразуем JSON в массив
            $responseData = json_decode($response, true);

            if($responseData['result'] == "OK" && $responseData['data'] == '1'){ // Если получили данные, то обновляем элемент
                $arrData = [
                    "ID" => $dataUser['ID'],
                    "STATUS" => "Да"
                ];  
            }
            else{
                $arrData = [
                    "ID" => $dataUser['ID'],
                    "STATUS" => "Нет"
                ]; 
            }

            $resultUpdate = Data::updateElement($arrData);


        }
    
    }


}


