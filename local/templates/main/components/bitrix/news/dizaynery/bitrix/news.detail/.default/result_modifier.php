<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
    die();
}

if($arResult['PROPERTIES']['ATT_PRODUCT']['VALUE']){
    $arResult['PRODUCTS_ID'] = $arResult['PROPERTIES']['ATT_PRODUCT']['VALUE'];
}
