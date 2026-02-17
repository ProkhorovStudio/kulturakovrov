<?php
namespace Prokhorov\b24;

use Bitrix\Main;
use Bitrix\Main\Loader;

Loader::IncludeModule('iblock');


class Iblockdata
{

    protected static $idIblock = 4;

    /*Добавление лида в систему, если его нет*/
    public static function add($data){
        
        if(!$data){
            return false;
        }
        
        $checkExist = self::checkExist($data);
        
        if($checkExist){
            $element = new \CIBlockElement;
        
            $arAddData = [
            	'IBLOCK_ID' => self::$idIblock,
            	'NAME' => $data,  
            ];
            
            if($elementId = $element->Add($arAddData)) {
            	$result =  'New ID: '.$elementId;
            }else {
            	$result = 'Error: '.$element->LAST_ERROR;
            }    
        }
        
    }
    
    
   /*Проверка на существование лида в системе*/ 
    public static function checkExist($id){
        
        if(!$id)
        {
            throw new \Exception("Не передано ID лида:");
        }
        
        $arFilter = [
            "IBLOCK_ID" => self::$idIblock, 
            "NAME" => $id
        ];
        
        $element = \CIBlockElement::GetList(
            [], 
            $arFilter, 
            false, 
            false, 
            [
                'NAME',
            ])->Fetch();
            
        if(!$element){
            return true;
        }    
    }
    
    public static function delete($id){
        
        if(!$id)
        {
            throw new \Exception("Не передано ID элемента:");
        }
        
        \CIBlockElement::Delete($id);
    }

}


