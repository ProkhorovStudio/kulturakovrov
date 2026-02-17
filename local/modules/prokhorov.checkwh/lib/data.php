<?php
namespace Prokhorov\Checkwh;
use Prokhorov\Checkwh\Api;
use Bitrix\Main\Loader;
Loader::IncludeModule('iblock');

class Data
{

    protected static $IBLOCK_ID= 5;
    
    public static function getElement() {

        $filter = [
            "IBLOCK_ID" => self::$IBLOCK_ID, 
            'PROPERTY_ATT_CHECK' => false
        ];

        $sort = [
            "SORT"=> "ASC"
        ];

        $select = ['ID','PROPERTY_ATT_PHONE'];

        $nTopCount = ['nTopCount' => 1];

        $element = \CIBlockElement::GetList($sort, $filter, false, $nTopCount, $select)->Fetch();

        if($element)
        {
            return $element;// Возвращаем элемент
        }
        else{
            $dateTime = date('Y-m-d H:i:s');
            addMessage2Log("Сбор данных завершен (Дата и время: {$dateTime})");
            return true; // отдаем true в агент, чтобы не прерывать работу
        } 
        return true;
    
    }

    public static function get(){
        $phone = self::getElement();

        if($phone){
            Api::checkWh($phone);
        }

        return "\\".__METHOD__."();";
    }

    public static function updateElement($data){

        if(!is_array($data)){
            addMessage2Log('Пришли некорректные данные в метод updateElement');
            return false;
        }

        if($data['ID']){
            $dataElement = self::getElementById($data['ID']);

            if($dataElement){
                $element = new \CIBlockElement;

                $propsElement = [
                    "ATT_PHONE" => $dataElement['ATT_PHONE'],
                    "ATT_CHECK" => 'YES',
                    "ATT_ENABLED" => $data['STATUS'],
                    "ATT_NUMBER_TYPE" => $dataElement['ATT_NUMBER_TYPE']
                ]; 

                $dataElement = [
                    "PROPERTY_VALUES" => $propsElement
                ];

                $result = $element->Update($data['ID'], $dataElement);

                return $result;
            }
        }
    }

    public static function getElementById($id){
        if(!$id){
            addMessage2Log('Не передан ID в метод getElementById');
            return false;
        }


        $filter = [
            "IBLOCK_ID" => self::$IBLOCK_ID, 
            'ID' => $id
        ];

        $obServ = \CIBlockElement::GetList (
            ["ID" => "ASC"],
            $filter,
            false,
            false,
            ['NAME','PROPERTY_ATT_PHONE','PROPERTY_ATT_NUMBER_TYPE']
        );

        while($arServ = $obServ->GetNext()){
            $dataElement = [
                "NAME"     => $arServ['NAME'],
                "ATT_PHONE" =>  $arServ['PROPERTY_ATT_PHONE_VALUE'],
                "ATT_NUMBER_TYPE" => $arServ['PROPERTY_ATT_NUMBER_TYPE_VALUE']
            ];
        }

        return $dataElement;

    }
    




}


