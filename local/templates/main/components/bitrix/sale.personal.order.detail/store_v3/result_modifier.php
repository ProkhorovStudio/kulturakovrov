<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
{
    die();
}
CModule::IncludeModule("iblock");
foreach ($arResult['BASKET'] as &$basketItem){

    $offerId = $basketItem['PRODUCT_ID'];

    if($offerId){
        $productId = CCatalogSku::GetProductInfo($offerId);
    }

    if($productId['ID']){
        $resElement = \CIBlockElement::GetList(
            [],
            [
                'IBLOCK_ID' => 1,
                'ID' => $productId['ID'],
            ],
            false,
            false,
            [
                'ID',
                'IBLOCK_ID',
                'PROPERTY_MORE_PHOTO',
            ]
        );

        if ($element = $resElement->getNext())
        {
            $photoProduct = $element['PROPERTY_MORE_PHOTO_VALUE'];
        }
    }

    if($photoProduct){
        $basketItem['PICTURE']['SRC'] = Cfile::GetPath($photoProduct);
    }

}