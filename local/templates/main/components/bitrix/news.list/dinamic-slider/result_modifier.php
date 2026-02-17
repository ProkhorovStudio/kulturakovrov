<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();


foreach ($arResult["ITEMS"] as &$arItem){
    if(!empty($arItem['PROPERTIES']['ATT_SLIDER']['VALUE'])){
        foreach ($arItem['PROPERTIES']['ATT_SLIDER']['VALUE'] as $imageId){
            $arItem['COVERS'][]  = CFile::GetPath($imageId);
        }

        $arResult['DOTS-SLIDER'][] = [
            "ID" =>$arItem['ID'],
            "NAME" => $arItem['PROPERTIES']['ATT_TYPE_COVER']['VALUE']
        ];
    }
}