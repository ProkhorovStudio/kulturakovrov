<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();



foreach ($arResult['ITEMS'] as $key =>  $arItem){
    if($arItem['PREVIEW_PICTURE']){
        $arResult['ITEMS'][$key]['PK_SLIDER'] = $arItem['PREVIEW_PICTURE']['SRC'];
    }
    if($arItem['DETAIL_PICTURE']){
        $arResult['ITEMS'][$key]['MOB_SLIDER'] = $arItem['DETAIL_PICTURE']['SRC'];
    }
}



