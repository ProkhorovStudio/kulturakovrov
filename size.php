<?php
define('STOP_STATISTICS', true);
require_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php');
use Bitrix\Main\Loader;


$iblock_id = 2;



if (CModule::IncludeModule('iblock')) {
    $arSelect = array('ID', 'IBLOCK_SECTION_ID', 'NAME','PROPERTY_Kollektsiya','PROPERTY_Razmer_teh','PROPERTY_ARTICLE','PROPERTY_Style','PROPERTY_Proizvoditel','PROPERTY_Kollektsiya','PROPERTY_Method','PROPERTY_Material','PROPERTY_Tsvet');
    $arFilter = array('IBLOCK_ID' => $iblock_id, 'ACTIVE' => 'Y', 'SECTION_ID' => [], "INCLUDE_SUBSECTIONS" => "Y");
    $row1 = CIBlockElement::GetList(array("ACTIVE_FROM" => "ASC"), $arFilter, false, array("nPageSize" => 2000), $arSelect);
    $offers = '';

    while ($mass_row1 = $row1->GetNext()) {

        $oldSize = $mass_row1['PROPERTY_RAZMER_TEH_VALUE'];

        if (preg_match('/(\d+)\s*x\s*(\d+)/', $oldSize, $arrSize)) {
            $width = $arrSize[1];
            $height = $arrSize[2];

            if($arrSize[2] > $arrSize[1]){
                $width = $arrSize[2];
                $height = $arrSize[1];
            }

            $arrProduct[] = [
                'ID' => $mass_row1['ID'],
                'ATT_WIDTH' => $width,
                'ATT_HEIGHT' =>  $height
            ];
        }

        unset($width,$height);
    }
}

if($arrProduct){

    /*foreach ($arrProduct as $product){
        $props = [
            'ATT_WIDTH' => $product['ATT_WIDTH'],
            'ATT_HEIGHT' =>  $product['ATT_HEIGHT']
        ];

        if($props){
            CIBlockElement::SetPropertyValues($product['ID'], $iblock_id, $product['ATT_WIDTH'], 'ATT_WIDTH');
            CIBlockElement::SetPropertyValues($product['ID'], $iblock_id, $product['ATT_HEIGHT'], 'ATT_HEIGHT');
        }


        unset($props);
    }*/
}

